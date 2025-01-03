<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Tag; // Pastikan untuk mengimpor model Tag
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tag = $request->input('tag'); // Query tag dari URL
    
        if ($tag) {
            // Filter catatan berdasarkan tag
            $notes = Note::where('user_id', auth()->id())
                ->whereHas('tags', function ($query) use ($tag) {
                    $query->where('name', 'like', '%' . $tag . '%');
                })
                ->paginate(10);
        } else {
            // Tampilkan semua catatan milik user jika tidak ada filter
            $notes = Note::where('user_id', auth()->id())->paginate(10);
        }
    
        return view('notes.index', compact('notes', 'tag'));
    }    

    public function create()
    {
        return view('notes.create'); // Pastikan view ini sesuai dengan file yang ada di resources/views/notes/create.blade.php
    }
    

    public function store(Request $request)
    {
        // Validasi input dari pengguna
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string', // Tags opsional
            'file' => 'nullable|file|max:1024000', // Batas ukuran file 1 GB
        ]);
    
        // Tambahkan user_id pengguna yang sedang login
        $validatedData['user_id'] = auth()->id();
    
        // Simpan catatan baru ke database
        $note = Note::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => auth()->id(),
        ]);
    
        // Proses penyimpanan file jika ada
        if ($request->hasFile('file')) {
            // Simpan file di disk 'public'
            $filePath = $request->file('file')->store('files', 'public');
            $note->file_path = $filePath;
            $note->save(); // Simpan path file ke database
        }
    
        // Proses tags jika ada
        if ($request->filled('tags')) {
            $tags = explode(',', $request->input('tags'));
            $tagIds = [];
            foreach ($tags as $tagName) {
                // Pastikan tag disimpan tanpa duplikasi
                $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
                $tagIds[] = $tag->id;
            }
            // Sinkronkan tags dengan catatan
            $note->tags()->sync($tagIds);
        }
    
        // Redirect dan tambahkan pesan flash
        return redirect()->route('notes.index')->with('message', 'Catatan berhasil disimpan!');
    }      

    public function show(Note $note)
    {
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'title' => 'required',
            'content' => 'required',
            'file' => 'nullable|file|max:2048',
        ]);
    
        // Update data catatan
        $note->update($request->only(['title', 'content']));
    
        // Periksa apakah ada file baru yang diupload
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($note->file_path && Storage::exists($note->file_path)) {
                Storage::delete($note->file_path);
            }
    
            // Simpan file baru di disk 'public'
            $filePath = $request->file('file')->store('files', 'public');
            $note->file_path = $filePath;
            $note->save();
        }
    
        // Kembalikan ke halaman indeks dengan pesan sukses
        session()->flash('message', 'Note updated successfully.');
    
        return redirect()->route('notes.index');
    }    
    
    public function destroy(Note $note)
    {
        // Hapus file jika ada
        if ($note->file_path && Storage::exists($note->file_path)) {
            Storage::delete($note->file_path);
        }

        $note->delete();
        session()->flash('message', 'Note deleted successfully.');
        return redirect()->route('notes.index');
    }

    public function search(Request $request)
    {
        \Log::info('Search function accessed');
        $query = $request->input('query');
        $notes = Note::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->get();
        \Log::info('Notes found: ', $notes->toArray());
        return view('notes.index', compact('notes'));
    }
    
}

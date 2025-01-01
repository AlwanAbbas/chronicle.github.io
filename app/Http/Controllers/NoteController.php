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
    public function index()
    {
        $notes = Note::where('user_id', auth()->id())->paginate(10);
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        // Menambahkan user_id dari pengguna yang sedang login
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            // Jika perlu, validasi input lain
        ]);
    
        // Menambahkan user_id langsung ke data yang akan disimpan
        $note = Note::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'user_id' => auth()->id(),  // Menambahkan user_id yang diambil dari pengguna yang sedang login
        ]);
    
        // Proses penyimpanan file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('files');
            $note->file_path = $filePath;
            $note->save();
        }
    
        // Pisahkan tags berdasarkan koma dan sinkronkan dengan note
        $tags = explode(',', $request->input('tags'));
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
            $tagIds[] = $tag->id;
        }
    
        // Menyinkronkan tag yang dipilih dengan catatan
        $note->tags()->sync($tagIds);
    
        // Redirect atau beri pesan flash
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
        // Update note yang ada
        $note->update($request->all());

        // Proses penyimpanan file baru dan hapus file lama jika ada
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($note->file_path && Storage::exists($note->file_path)) {
                Storage::delete($note->file_path);
            }
            $filePath = $request->file('file')->store('files');
            $note->file_path = $filePath;
            $note->save();
        }

        // Pisahkan tags berdasarkan koma dan sinkronkan dengan note
        $tags = explode(',', $request->input('tags'));
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
            $tagIds[] = $tag->id;
        }
        $note->tags()->sync($tagIds);

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

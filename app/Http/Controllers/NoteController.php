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
        $notes = Note::all();
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        // Simpan note baru
        $note = Note::create($request->all());

        // Proses penyimpanan file
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
        $note->tags()->sync($tagIds);

        return redirect()->route('notes.index');
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

        return redirect()->route('notes.index');
    }

    public function destroy(Note $note)
    {
        // Hapus file jika ada
        if ($note->file_path && Storage::exists($note->file_path)) {
            Storage::delete($note->file_path);
        }

        $note->delete();
        return redirect()->route('notes.index');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $notes = Note::where('title', 'LIKE', "%{$query}%")
                    ->orWhere('content', 'LIKE', "%{$query}%")
                    ->get();
    
        return view('notes.index', compact('notes'));
    }
    
}

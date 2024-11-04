<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Note</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Note</h1>
        
        <!-- Form untuk mengedit catatan -->
        <form action="{{ route('notes.update', $note) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Input Judul -->
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title" class="form-control" value="{{ $note->title }}" required>
            </div>
            
            <!-- Input Konten -->
            <div class="form-group">
                <label>Content:</label>
                <textarea name="content" class="form-control" required>{{ $note->content }}</textarea>
            </div>
            
            <!-- Input Tags -->
            <div class="form-group">
                <label>Tags:</label>
                <input type="text" name="tags" class="form-control" placeholder="Enter tags, separated by commas" value="{{ implode(',', $note->tags->pluck('name')->toArray()) }}">
            </div>
            
            <!-- Input File -->
            <div class="form-group">
                <label>File:</label>
                <input type="file" name="file" class="form-control">
            </div>
            
            <!-- Tombol Simpan -->
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        
        <!-- Tombol Kembali -->
        <a href="{{ route('notes.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</body>
</html>

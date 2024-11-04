<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Note</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create Note</h1>
        
        <!-- Form untuk membuat catatan baru -->
        <form action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data"> 
            @csrf

            <!-- Input Judul -->
            <div class="form-group">
                <label>Title:</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            
            <!-- Input Konten -->
            <div class="form-group">
                <label>Content:</label>
                <textarea name="content" class="form-control" required></textarea>
            </div>
            
            <!-- Input Tags -->
            <div class="form-group">
                <label>Tags:</label>
                <input type="text" name="tags" class="form-control" placeholder="Enter tags, separated by commas">
            </div>
            
            <!-- Input File Dengan Styling -->
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

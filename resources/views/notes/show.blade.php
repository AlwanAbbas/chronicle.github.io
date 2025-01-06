<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $note->title }}</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>{{ $note->title }}</h1>
        <p>{{ $note->content }}</p>
        
        <p><strong>Tags:</strong> {{ implode(', ', $note->tags->pluck('name')->toArray()) }}</p>
        
        @if($note->file_path)
            <p><strong>File:</strong> <a href="{{ asset('storage/' . $note->file_path) }}" download>Download</a></p>
            
            <!-- File Preview -->
            <div class="mt-3">
                <strong>Preview:</strong>
                @if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $note->file_path))
                    <!-- Image Preview -->
                    <img src="{{ asset('storage/' . $note->file_path) }}" alt="File Preview" class="img-fluid mt-2">
                @elseif(preg_match('/\.pdf$/i', $note->file_path))
                    <!-- PDF Preview -->
                    <iframe src="{{ asset('storage/' . $note->file_path) }}" class="w-100 mt-2" style="height: 500px;" frameborder="0"></iframe>
                @else
                    <!-- Unsupported File Type -->
                    <p class="text-warning mt-2">Preview not available for this file type.</p>
                @endif
            </div>
        @endif
        
        <a href="{{ route('notes.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>
</body>
</html>

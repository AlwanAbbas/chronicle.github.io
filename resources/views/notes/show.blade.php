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
        
        <p><strong>Tags:</strong> {{ implode(',', $note->tags->pluck('name')->toArray()) }}</p>
        
        @if($note->file_path)
            <p><strong>File:</strong> <a href="{{ asset('storage/' . $note->file_path) }}" download>Download</a></p>
        @endif
        
        <a href="{{ route('notes.index') }}" class="btn btn-secondary">Back</a>
    </div>
</body>
</html>

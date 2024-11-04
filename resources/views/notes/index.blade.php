<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chronicle - Notes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Notes</h1>
        
        <!-- Search form -->
        <form action="{{ route('notes.search') }}" method="GET" class="form-inline mb-3">
            <input type="text" name="query" class="form-control mr-sm-2" placeholder="Search notes...">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Create Note button -->
        <a href="{{ route('notes.create') }}" class="btn btn-success mb-3">Create Note</a>
        
        <!-- Notes table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notes as $note)
                <tr>
                    <td>
                        <a href="{{ route('notes.show', $note) }}">{{ $note->title }}</a>
                    </td>
                    <td>
                        <a href="{{ route('notes.edit', $note) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>

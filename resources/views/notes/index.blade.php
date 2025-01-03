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
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h3">Chronicle</h1>

            <!-- Auth buttons: Login/Profile Dropdown -->
            @if (Auth::check())
                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                        <div class="dropdown-divider"></div>
                        <button type="button" class="dropdown-item text-danger" data-toggle="modal" data-target="#logoutModal">
                            Logout
                        </button>
                    </div>
                </div>
            @else
                <!-- Login/Register buttons -->
                <div>
                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-success btn-sm">Register</a>
                </div>
            @endif
        </div>

        <!-- Display flash message -->
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif

        <!-- Form Pencarian Tags -->
        <form action="{{ route('notes.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input 
                    type="text" 
                    name="tag" 
                    value="{{ request('tag') }}" 
                    placeholder="Cari berdasarkan tag..."
                    class="form-control"
                >
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </div>
        </form>

        <!-- Reset pencarian jika filter tag diterapkan -->
        @if(request('tag'))
            <div class="alert alert-info">
                <p>
                    Hasil pencarian untuk tag: <strong>{{ request('tag') }}</strong>
                </p>
                <a href="{{ route('notes.index') }}" class="btn btn-sm btn-secondary">Reset Pencarian</a>
            </div>
        @endif

        <!-- Create Note button -->
        @if (Auth::check())
            <a href="{{ route('notes.create') }}" class="btn btn-success mb-3">Buat Catatan</a>
        @else
            <div class="alert alert-warning">Please log in to create and manage notes.</div>
        @endif

        <!-- Notes table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Tags</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notes as $note)
                    <tr>
                        <td><a href="{{ route('notes.show', $note) }}">{{ $note->title }}</a></td>
                        <td>
                            @foreach ($note->tags as $tag)
                                <span class="badge badge-{{ $tag->color ?? 'info' }}">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('notes.edit', $note) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('notes.destroy', $note) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" id="deleteBtn" class="btn btn-danger btn-sm">
                                    <span id="deleteSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No notes found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $notes->links() }}
        </div>

        <!-- Logout Modal -->
        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to logout?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('deleteBtn').addEventListener('click', function () {
            document.getElementById('deleteSpinner').classList.remove('d-none');
        });
    </script>
</body>
</html>

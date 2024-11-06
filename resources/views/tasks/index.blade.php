<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Task Manager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Dropdown untuk User -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Sign Out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="mb-4">To-Do List</h1>

        <!-- Notifikasi sukses -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol Tambah Tugas Baru -->
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Add New Task</a>

        <!-- Tabel Daftar Tugas -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Due Date</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</td>
                        <td>{{ ucfirst($task->priority) }}</td>
                        <td>
                            @if ($task->status === 'completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <!-- Toggle Status -->
                            <form action="{{ route('tasks.toggleStatus', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm {{ $task->status === 'completed' ? 'btn-warning' : 'btn-success' }}">
                                    {{ $task->status === 'completed' ? 'Mark as Pending' : 'Mark as Complete' }}
                                </button>
                            </form>

                            <!-- Edit Task -->
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary">Edit</a>

                            <!-- Delete Task -->
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

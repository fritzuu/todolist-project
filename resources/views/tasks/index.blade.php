<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task List with Calendar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Default Light Mode */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }
    
        .navbar {
            background-color: #007bff;
        }
    
        .navbar a {
            color: white
        }
    
        .navbar .navbar-toggler {
            border-color: #007bff;
        }
    
        .navbar-toggler-icon {
            background-color: white;
        }
    
        .container {
            margin-top: 50px;
        }
    
        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    
        .table th, .table td {
            vertical-align: middle;
        }
    
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
    
        #calendar {
            max-width: 100%;
            height: 300px;
            font-size: 0.9em;
            border-radius: 8px;
        }
    
        /* Button hover effects */
        .btn:hover {
            cursor: pointer;
            opacity: 0.8;
        }
    
        /* Better spacing in form inputs */
        .input-group {
            margin-bottom: 15px;
        }
    
        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #121212;
            color: #f8f9fa;
        }
    
        .dark-mode .navbar {
            background-color: #333;
        }
    
        .dark-mode .navbar a {
            color: #f8f9fa;
        }
    
        .dark-mode .navbar-toggler-icon {
            background-color: #333;
        }
    
        .dark-mode .card {
            background-color: #1e1e1e;
            color: #f8f9fa;
            box-shadow: 0 4px 6px rgba(255, 255, 255, 0.1);
        }
    
        .dark-mode .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
    
        .dark-mode .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
    
        .dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background-color: #2c2c2c;
        }
    </style>
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Task Manager</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
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

    <div class="container">
        <div class="card">
            <h1 class="mb-4">To-Do List</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Add New Task Button -->
            <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Add New Task</a>

            <!-- Search Form -->
            <form action="{{ route('tasks.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Search tasks..." value="{{ request()->query('search') }}">
                    <button type="submit" class="btn btn-outline-secondary">Search</button>
                </div>
            </form>

            <!-- Calendar -->
            <div id="calendar" class="mb-5"></div>
        </div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
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
                @php $counter = 1; @endphp
                @foreach ($tasks as $task)
                    <tr>
                        <td>{{ $counter++ }}</td>
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
                            <form action="{{ route('tasks.toggleStatus', $task->id) }}" method="POST" class="toggle-status-form" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="button" class="btn btn-sm {{ $task->status === 'completed' ? 'btn-warning' : 'btn-success' }}" onclick="confirmToggleStatus(this)">
                                    {{ $task->status === 'completed' ? 'Mark as Pending' : 'Mark as Complete' }}
                                </button>
                            </form>

                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-primary">Edit</a>

                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="delete-form" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(this)">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $tasks->links('pagination::bootstrap-4') }}
    </div>
</div>


        </div>
    </div>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.5/index.global.min.js"></script>
    <script>
        
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                displayEventTime: false,
                events: [
                    @foreach ($tasks as $task)
                    {
                        title: '{{ $task->title }}',
                        start: '{{ $task->due_date }}',
                        color: '{{ $task->status === "completed" ? "#28a745" : "#ffc107" }}'
                    },
                    @endforeach
                ]
            });
            calendar.render();
        });

        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        function confirmToggleStatus(button) {
            const actionText = button.textContent.trim();
            Swal.fire({
                title: `Are you sure you want to ${actionText}?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
</body>
</html>

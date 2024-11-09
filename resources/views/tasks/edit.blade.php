<!-- resources/views/tasks/edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
        .form-label {
            font-weight: bold;
        }
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary, .btn-secondary {
            transition: all 0.3s ease;
        }
        .btn-primary:hover, .btn-secondary:hover {
            transform: translateY(-2px);
        }
        .btn-secondary {
            margin-left: 10px;
        }
        .tooltip-inner {
            background-color: #007bff;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2>Edit Task</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label" data-bs-toggle="tooltip" title="Enter the task title.">Title</label>
                    <input type="text" name="title" class="form-control" id="title" value="{{ $task->title }}" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label" data-bs-toggle="tooltip" title="Provide a detailed description of the task.">Description</label>
                    <textarea name="description" class="form-control" id="description" rows="3">{{ $task->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="due_date" class="form-label" data-bs-toggle="tooltip" title="Set the due date for the task.">Due Date</label>
                    <input type="date" name="due_date" class="form-control" id="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                </div>

                <div class="mb-3">
                    <label for="priority" class="form-label" data-bs-toggle="tooltip" title="Choose the priority level.">Priority</label>
                    <select name="priority" class="form-control" id="priority" required>
                        <option value="high" {{ $task->priority === 'high' ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ $task->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low" {{ $task->priority === 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Update Task</button>
                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Task List</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = Array.from(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>

</body>
</html>

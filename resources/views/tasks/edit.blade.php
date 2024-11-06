<!-- resources/views/tasks/edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Task</h1>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" class="form-control" id="title" value="{{ $task->title }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" id="description" rows="3">{{ $task->description }}</textarea>
            </div>
            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" class="form-control" id="due_date" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
            </div>
            <div class="mb-3">
                <label for="priority" class="form-label">Priority</label>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

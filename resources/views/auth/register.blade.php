<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="login-container">
            <h2 class="mb-4 text-center">Create an Account</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="text" name="name" class="form-control" id="name" placeholder="Full Name" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" id="email" placeholder="Email Address" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Register</button>
                <a href="{{ route('login') }}" class="btn btn-secondary w-100 mt-2">Back to Login</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

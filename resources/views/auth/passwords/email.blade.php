<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Builder Corporation - Reset Password</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f5f5f5;
        }
        .reset-container {
            max-width: 500px;
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #FF8000;
            padding: 20px;
            text-align: center;
        }
        .header img {
            height: 80px;
        }
        .header h1 {
            color: #fff;
            margin-top: 10px;
            font-size: 24px;
        }
        .form-container {
            padding: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-control:focus {
            outline: none;
            border-color: #FF8000;
            box-shadow: 0 0 0 2px rgba(255, 128, 0, 0.2);
        }
        .btn-reset {
            background-color: #7bc62d;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            text-transform: uppercase;
        }
        .btn-reset:hover {
            background-color: #69a826;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: #666;
            text-decoration: none;
        }
        .back-link a:hover {
            color: #FF8000;
            text-decoration: underline;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="header">
            <img src="{{ asset('images/builder-logo.png') }}" alt="Builder Corporation Logo" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNTAiIGhlaWdodD0iMTUwIiB2aWV3Qm94PSIwIDAgMTUwIDE1MCIgZmlsbD0ibm9uZSI+PHJlY3Qgd2lkdGg9IjE1MCIgaGVpZ2h0PSIxNTAiIGZpbGw9IiNGRjgwMDAiIC8+PHBhdGggZD0iTTc1IDUwQzY3LjUgNTAgNjIuNSA1Ni4yNSA2Mi41IDYyLjVDNjIuNSA2OC43NSA2OC43NSA3NSA2OC43NSA3NUw4NSAxMDBMNzcuNSAxMTYuMjVMNjIuNSAxMzIuNSIgc3Ryb2tlPSJibGFjayIgc3Ryb2tlLXdpZHRoPSI0Ii8+PGNpcmNsZSBjeD0iODUiIGN5PSIxMDUiIHI9IjEwIiBmaWxsPSIjMDAwIi8+PC9zdmc+'; this.style.backgroundColor='#FF8000';">
            <h1>Reset Password</h1>
        </div>

        <div class="form-container">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                    @error('email')
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-reset">
                        Send Password Reset Link
                    </button>
                </div>
            </form>

            <div class="back-link">
                <a href="{{ route('login') }}">
                    Back to Login
                </a>
            </div>
        </div>
    </div>
</body>
</html>

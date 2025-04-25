<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rapid Concretech - Forgot Password</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 400px;
            width: 100%;
            background-color: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 20px;
        }

        .status-message {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            background-color: #d4edda;
            color: #155724;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .input-group input:focus {
            outline: none;
            border-color: #FF8000;
        }

        .submit-button {
            background-color: #FF8000;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .submit-button:hover {
            background-color: #e67300;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #666;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/Rapid.jpg') }}" alt="Rapid Concretech Logo" class="logo-img">
            <div class="title">Reset Password</div>
            <div class="subtitle">Enter your email to receive a password reset link</div>
        </div>

        @if (session('status'))
            <div class="status-message">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                @error('email')
                    <div style="color: red; font-size: 14px; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="submit-button">Send Reset Link</button>
        </form>

        <div class="back-link">
            <a href="{{ route('login') }}">Back to Login</a>
        </div>
    </div>
</body>
</html>
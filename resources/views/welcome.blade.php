<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Builder Corporation - Login</title>
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
        .login-container {
            display: flex;
            max-width: 900px;
            overflow: hidden;
        }
        .branding {
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            width: 50%;
        }
        .logo {
            width: 180px;
            height: 180px;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
        }
        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .company-name {
            font-weight: 700;
            font-size: 28px;
            color: #333;
            margin-bottom: 5px;
        }
        .tagline {
            font-size: 18px;
            color: #666;
        }
        .login-form {
            background-color: #7bc62d;
            padding: 50px;
            width: 350px;
            display: flex;
            flex-direction: column;
            border-radius: 4px;
        }
        .login-form h2 {
            color: #fff;
            font-size: 20px;
            margin-bottom: 30px;
            text-align: center;
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        .form-group label {
            position: absolute;
            left: 10px;
            top: 12px;
            color: #333;
        }
        .form-control {
            width: 100%;
            padding: 12px 12px 12px 35px;
            border: none;
            border-radius: 0;
            font-size: 16px;
            box-sizing: border-box;
            height: 45px;
        }
        .form-control:focus {
            outline: none;
        }
        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .forgot-password a {
            color: #fff;
            text-decoration: none;
        }
        .forgot-password a:hover {
            text-decoration: underline;
        }
        .btn-login {
            background-color: #000;
            color: #fff;
            border: none;
            padding: 14px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            text-transform: uppercase;
            height: 50px;
        }
        .btn-login:hover {
            background-color: #333;
        }
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                align-items: center;
            }
            .branding, .login-form {
                width: 350px;
                padding: 20px;
            }
            .logo {
                width: 150px;
                height: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="branding">
            <div class="logo">
                <img src="{{ asset('images/Rapid.jpg') }}" alt="Builder Corporation Logo">
            </div>
            <h1 class="company-name">Builder Corporation</h1>
            <p class="tagline">Builders Corporation</p>
        </div>
        <div class="login-form">
            <h2>LOGIN</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="email">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2" />
                            <path d="M22 7l-10 7L2 7" />
                        </svg>
                    </label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="password">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0110 0v4" />
                        </svg>
                    </label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                </div>
                <button type="submit" class="btn-login">LOGIN</button>
            </form>
        </div>
    </div>
</body>
</html>

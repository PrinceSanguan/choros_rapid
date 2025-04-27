<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Rapid Concretech</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            flex-direction: column;
            width: 95%;
            max-width: 800px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        .logo-section {
            background-color: white;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .logo {
            width: 90px;
            height: 90px;
            margin-bottom: 15px;
            object-fit: contain;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 5px;
        }

        .company-slogan {
            font-size: 13px;
            color: #666;
            text-align: center;
        }

        .login-section {
            background-color: #FF8000;
            padding: 25px 20px;
            width: 100%;
        }

        .login-header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
            color: black;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: black;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .input-icon {
            position: relative;
        }

        .input-icon svg {
            position: absolute;
            left: 8px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
            width: 14px;
            height: 14px;
        }

        .input-icon input {
            padding-left: 30px;
        }

        .forgot-link {
            display: block;
            text-align: right;
            margin-bottom: 15px;
            font-size: 13px;
            color: black;
            text-decoration: none;
        }

        .btn-login {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-login:hover {
            background-color: #333;
        }

        .error-alert {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 13px;
        }

        /* Tablet and desktop styles */
        @media (min-width: 768px) {
            .container {
                flex-direction: row;
                width: 90%;
            }

            .logo-section {
                width: 50%;
                padding: 40px;
            }

            .login-section {
                width: 50%;
                padding: 40px;
            }

            .logo {
                width: 120px;
                height: 120px;
                margin-bottom: 20px;
            }

            .company-name {
                font-size: 24px;
            }

            .company-slogan {
                font-size: 14px;
            }

            .login-header {
                font-size: 20px;
                margin-bottom: 30px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-control {
                padding: 12px;
                font-size: 16px;
            }

            .input-icon svg {
                left: 10px;
                width: 16px;
                height: 16px;
            }

            .input-icon input {
                padding-left: 35px;
            }

            .forgot-link {
                margin-bottom: 20px;
                font-size: 14px;
            }

            .btn-login {
                padding: 12px;
                font-size: 16px;
            }
        }

        /* Small mobile devices */
        @media (max-width: 375px) {
            .container {
                width: 100%;
                border-radius: 0;
            }

            .logo-section {
                padding: 20px 15px;
            }

            .logo {
                width: 80px;
                height: 80px;
                margin-bottom: 10px;
            }

            .company-name {
                font-size: 18px;
            }

            .company-slogan {
                font-size: 12px;
            }

            .login-section {
                padding: 20px 15px;
            }

            .login-header {
                font-size: 16px;
                margin-bottom: 15px;
            }

            .form-control {
                padding: 8px;
                font-size: 13px;
            }

            .forgot-link {
                font-size: 12px;
                margin-bottom: 12px;
            }

            .btn-login {
                padding: 8px;
                font-size: 14px;
            }
        }

        /* For landscape orientation on mobile */
        @media (max-height: 500px) and (orientation: landscape) {
            body {
                padding: 10px 0;
            }

            .container {
                flex-direction: row;
            }

            .logo-section {
                width: 40%;
                padding: 15px;
            }

            .login-section {
                width: 60%;
                padding: 15px 20px;
            }

            .logo {
                width: 70px;
                height: 70px;
                margin-bottom: 10px;
            }

            .form-group {
                margin-bottom: 10px;
            }

            .forgot-link {
                margin-bottom: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-section">
            <img src="{{ asset('images/Rapid.jpg') }}" alt="Rapid Concretech Logo" class="logo">
            <div class="company-name">Rapid Concretech</div>
            <div class="company-slogan">Building Excellence</div>
        </div>

        <div class="login-section">
            <div class="login-header">LOGIN</div>

            @if ($errors->any())
                <div class="error-alert">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                        </svg>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                        </svg>
                        <input id="password" type="password" class="form-control" name="password" required autocomplete="current-password" placeholder="Password">
                    </div>
                </div>

                <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>

                <button type="submit" class="btn-login">
                    LOGIN
                </button>
            </form>
        </div>
    </div>
</body>
</html>
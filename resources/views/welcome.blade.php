<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rapid Concretech - Login</title>
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
            display: flex;
            max-width: 800px;
            width: 100%;
            background-color: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .logo-section {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .logo-img {
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }

        .company-slogan {
            font-size: 16px;
            color: #666;
        }

        .login-section {
            flex: 1;
            background-color: #FF8000;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 30px;
            color: black;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .input-group input:focus {
            outline: none;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .forgot-password a {
            color: black;
            text-decoration: none;
        }

        .login-button {
            background-color: black;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .login-button:hover {
            background-color: #333;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                margin: 20px;
            }

            .logo-section, .login-section {
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-section">
            <img src="{{ asset('images/Rapid.jpg') }}" alt="Rapid Concretech Logo" class="logo-img">
            <div class="company-name">Rapid Concretech</div>
            <div class="company-slogan">Building Excellence</div>
        </div>

        <div class="login-section">
            <div class="login-header">LOGIN</div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>

                <div class="input-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="forgot-password">
                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                </div>

                <button type="submit" class="login-button">LOGIN</button>
            </form>
        </div>
    </div>
</body>
</html>
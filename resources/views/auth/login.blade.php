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
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .container {
            display: flex;
            flex-direction: column;
            width: 95%;
            max-width: 900px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }

        .logo-section {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
            border-bottom: 3px solid #76cd26;
        }

        .logo {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            object-fit: contain;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .company-name {
            font-size: 26px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            color: #2d3748;
        }

        .company-slogan {
            font-size: 14px;
            color: #718096;
            text-align: center;
            font-weight: 500;
        }

        .login-section {
            background-color: #76cd26;
            padding: 35px 25px;
            width: 100%;
        }

        .login-header {
            text-align: center;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #1a202c;
            letter-spacing: 1px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1a202c;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid rgba(0, 0, 0, 0.1);
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 15px;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: #1a202c;
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.1);
        }

        .input-icon {
            position: relative;
        }

        .input-icon svg {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #718096;
            width: 18px;
            height: 18px;
        }

        .input-icon input {
            padding-left: 40px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 10px;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .error-alert {
            background-color: #fed7d7;
            color: #c53030;
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            border-left: 4px solid #c53030;
            font-weight: 500;
        }

        .test-credentials {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            padding: 20px;
            margin-top: 25px;
            border: 2px solid rgba(0, 0, 0, 0.1);
        }

        .test-credentials-header {
            font-size: 16px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 15px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .credential-item {
            background: white;
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 6px;
            border-left: 4px solid #76cd26;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .credential-item:hover {
            transform: translateX(4px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .credential-item:last-child {
            margin-bottom: 0;
        }

        .credential-role {
            font-weight: 700;
            color: #1a202c;
            font-size: 13px;
            margin-bottom: 4px;
            text-transform: uppercase;
        }

        .credential-email {
            font-size: 13px;
            color: #4a5568;
            font-family: 'Courier New', monospace;
        }

        .credential-password {
            font-size: 13px;
            color: #4a5568;
            font-family: 'Courier New', monospace;
        }

        /* Tablet and desktop styles */
        @media (min-width: 768px) {
            body {
                padding: 40px;
            }

            .container {
                flex-direction: row;
                width: 90%;
                max-width: 1100px;
            }

            .logo-section {
                width: 45%;
                padding: 50px 40px;
                border-bottom: none;
                border-right: 3px solid #76cd26;
            }

            .login-section {
                width: 55%;
                padding: 50px 40px;
            }

            .logo {
                width: 140px;
                height: 140px;
                margin-bottom: 25px;
            }

            .company-name {
                font-size: 30px;
            }

            .company-slogan {
                font-size: 16px;
            }

            .login-header {
                font-size: 24px;
                margin-bottom: 35px;
            }

            .form-group {
                margin-bottom: 22px;
            }

            .form-control {
                padding: 14px;
                font-size: 16px;
            }

            .input-icon svg {
                left: 14px;
                width: 20px;
                height: 20px;
            }

            .input-icon input {
                padding-left: 45px;
            }

            .btn-login {
                padding: 16px;
                font-size: 17px;
            }

            .credential-item {
                padding: 14px;
            }

            .credential-role {
                font-size: 14px;
            }

            .credential-email,
            .credential-password {
                font-size: 14px;
            }
        }

        /* Small mobile devices */
        @media (max-width: 375px) {
            body {
                padding: 10px;
            }

            .container {
                width: 100%;
                border-radius: 8px;
            }

            .logo-section {
                padding: 25px 15px;
            }

            .logo {
                width: 80px;
                height: 80px;
                margin-bottom: 15px;
            }

            .company-name {
                font-size: 20px;
            }

            .company-slogan {
                font-size: 12px;
            }

            .login-section {
                padding: 25px 20px;
            }

            .login-header {
                font-size: 18px;
                margin-bottom: 20px;
            }

            .form-control {
                padding: 10px;
                font-size: 14px;
            }

            .btn-login {
                padding: 12px;
                font-size: 15px;
            }

            .test-credentials {
                padding: 15px;
                margin-top: 20px;
            }

            .credential-item {
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="logo-section">
            <img src="{{ asset('images/Rapid.jpg') }}" alt="Rapid Concretech Logo" class="logo">
            <div class="company-name">Rapid Concretech</div>
            <div class="company-slogan">Builders Corporation</div>
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
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z" />
                        </svg>
                        <input id="email" type="email" class="form-control" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Enter your email">
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z" />
                        </svg>
                        <input id="password" type="password" class="form-control" name="password" required
                            autocomplete="current-password" placeholder="Enter your password">
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    LOGIN
                </button>
            </form>

            <div class="test-credentials">
                <div class="test-credentials-header">🔐 Test Accounts</div>

                <div class="credential-item" onclick="fillCredentials('admin@gmail.com', 'password123')">
                    <div class="credential-role">👨‍💼 Admin</div>
                    <div class="credential-email">📧 admin@gmail.com</div>
                    <div class="credential-password">🔑 password123</div>
                </div>

                <div class="credential-item" onclick="fillCredentials('pm@gmail.com', 'password123')">
                    <div class="credential-role">📋 Project Manager</div>
                    <div class="credential-email">📧 pm@gmail.com</div>
                    <div class="credential-password">🔑 password123</div>
                </div>

                <div class="credential-item" onclick="fillCredentials('accountant@gmail.com', 'password123')">
                    <div class="credential-role">💰 Accountant</div>
                    <div class="credential-email">📧 accountant@gmail.com</div>
                    <div class="credential-password">🔑 password123</div>
                </div>

                <div class="credential-item" onclick="fillCredentials('inventory@gmail.com', 'password123')">
                    <div class="credential-role">📦 Inventory Staff</div>
                    <div class="credential-email">📧 inventory@gmail.com</div>
                    <div class="credential-password">🔑 password123</div>
                </div>

                <div class="credential-item" onclick="fillCredentials('supplier@gmail.com', 'password123')">
                    <div class="credential-role">🚚 Supplier</div>
                    <div class="credential-email">📧 supplier@gmail.com</div>
                    <div class="credential-password">🔑 password123</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;

            // Add a subtle animation feedback
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');

            emailInput.style.borderColor = '#76cd26';
            passwordInput.style.borderColor = '#76cd26';

            setTimeout(() => {
                emailInput.style.borderColor = '';
                passwordInput.style.borderColor = '';
            }, 1000);
        }
    </script>
</body>

</html>

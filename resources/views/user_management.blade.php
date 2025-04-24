<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>User Management - Rapid Concretech</title>

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
            background-color: #f5f5f5;
            color: #333;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #FF8000;
            color: #000;
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .logo-container {
            display: flex;
            align-items: center;
            padding: 0 20px 20px 20px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .logo {
            width: 60px;
            height: 60px;
            border-radius: 10%;
            margin-right: 10px;
        }

        .logo-text {
            font-weight: bold;
            font-size: 18px;
        }

        .menu {
            flex: 1;
        }

        .menu-item {
            padding: 12px 20px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .menu-item:hover {
            background-color: rgba(0, 0, 0, 0.1);
        }

        .menu-item.active {
            background-color: rgba(0, 0, 0, 0.1);
            font-weight: 600;
        }

        .submenu {
            padding-left: 30px;
            display: block;
        }

        .submenu-item {
            padding: 8px 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #000;
        }

        .submenu-item:hover {
            background-color: rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .submenu-item::before {
            content: "— ";
            margin-right: 5px;
        }

        .arrow {
            transition: transform 0.3s;
        }

        .rotate {
            transform: rotate(180deg);
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .datetime {
            font-size: 14px;
            color: #666;
        }

        .user-dropdown {
            position: relative;
            display: inline-block;
        }

        .user-dropdown-btn {
            background: none;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #333;
        }

        .user-dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
        }

        .user-dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .user-dropdown-content a:hover {
            background-color: #f1f1f1;
            border-radius: 4px;
        }

        .user-dropdown:hover .user-dropdown-content {
            display: block;
        }

        .user-icon {
            margin-right: 5px;
            width: 18px;
            height: 18px;
        }

        .content-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .action-button {
            background-color: #FF8000;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }

        .action-button:hover {
            background-color: #e67300;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
        }

        .data-table th {
            background-color: #f1f1f1;
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .data-table td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        .data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .data-table tr:hover {
            background-color: #f1f1f1;
        }

        .action-links a {
            text-decoration: none;
            margin: 0 5px;
        }

        .action-links a.edit {
            color: blue;
        }

        .action-links a.delete {
            color: red;
        }

        a {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-container">
                <img src="{{ asset('images/Rapid.jpg') }}" alt="Rapid Concretech Logo" class="logo">
                <div class="logo-text">Rapid Concretech</div>
            </div>

            <div class="menu">
                <a href="{{ route('admin_dashboard') }}" class="menu-item">Dashboard</a>

                <div class="menu-item active">
                    User Management
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu">
                    <a href="{{ route('users.index') }}" class="submenu-item">Manage Users</a>
                    <a href="{{ route('users.create') }}" class="submenu-item">Add Users</a>
                </div>

                <div class="menu-item">
                    Project Management
                    <span class="arrow">▼</span>
                </div>

                <div class="menu-item">
                    Billing Transaction
                    <span class="arrow">▼</span>
                </div>

                <div class="menu-item">
                    Inventory
                    <span class="arrow">▼</span>
                </div>

                <div class="menu-item">
                    Suppliers
                    <span class="arrow">▼</span>
                </div>

                <div class="menu-item">
                    Customer Data
                    <span class="arrow">▼</span>
                </div>

                <div class="menu-item">
                    Reports
                    <span class="arrow">▼</span>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="content-header">
                <div class="datetime">
                    {{ now()->format('F j, Y, g:i a') }}
                </div>

                <div class="user-dropdown">
                    <button class="user-dropdown-btn">
                        <svg class="user-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        Admin ▼
                    </button>
                    <div class="user-dropdown-content">
                        <a href="#">Profile</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            <div class="content-main">
                <div class="content-title">Manage Users</div>

                <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                    <div>
                        <h2>User List</h2>
                    </div>
                    <div>
                        <a href="{{ route('users.create') }}" class="action-button">Add New</a>
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Position</th>
                            <th>Last Login</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users ?? [] as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->position }}</td>
                            <td>{{ $user->last_login_at ?? 'Never' }}</td>
                            <td class="action-links">
                                <a href="{{ route('users.edit', $user->id) }}" class="edit">Edit</a> |
                                <a href="#" class="delete" onclick="event.preventDefault(); if(confirm('Are you sure you want to delete this user?')) document.getElementById('delete-form-{{ $user->id }}').submit();">Delete</a>
                                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach

                        @if(empty($users ?? []))
                        <tr>
                            <td colspan="5" style="text-align: center;">No users found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Toggle submenu visibility
        document.querySelectorAll('.menu-item').forEach(item => {
            if (!item.classList.contains('active')) {
                const submenu = item.nextElementSibling;
                if (submenu && submenu.classList.contains('submenu')) {
                    submenu.style.display = 'none';
                }
            }

            item.addEventListener('click', event => {
                if (event.currentTarget.querySelector('.arrow')) {
                    const arrow = event.currentTarget.querySelector('.arrow');
                    arrow.classList.toggle('rotate');

                    const submenu = event.currentTarget.nextElementSibling;
                    if (submenu && submenu.classList.contains('submenu')) {
                        submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
                    }
                }
            });
        });
    </script>
</body>
</html>

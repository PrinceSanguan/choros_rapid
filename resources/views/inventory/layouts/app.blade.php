<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rapid Concretech') }} - Inventory</title>

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
            position: fixed;
            height: 100vh;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar.collapsed .logo-text,
        .sidebar.collapsed .menu-item span,
        .sidebar.collapsed .submenu {
            display: none;
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
            overflow-y: auto;
        }

        .menu-item {
            padding: 12px 20px;
            cursor: pointer;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-decoration: none;
            color: #000;
        }

        .menu-item:hover {
            background-color: rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .menu-item.active {
            background-color: rgba(0, 0, 0, 0.1);
            font-weight: 600;
            text-decoration: none;
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

        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 70px;
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

        .position-badge {
            background-color: rgba(255, 128, 0, 0.2);
            padding: 2px 8px;
            border-radius: 20px;
            font-size: 12px;
            margin-left: 5px;
            color: #FF8000;
            font-weight: 600;
        }

        .sidebar-toggle {
            position: absolute;
            top: 10px;
            right: -15px;
            width: 30px;
            height: 30px;
            background-color: #FF8000;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
            z-index: 1001;
            border: 2px solid #fff;
        }

        .toggle-icon {
            color: #fff;
            font-size: 14px;
            transition: transform 0.3s;
        }

        .sidebar.collapsed .toggle-icon {
            transform: rotate(180deg);
        }

        /* Hamburger Icon Styles */
        .hamburger-icon {
            width: 18px;
            height: 14px;
            position: relative;
            transform: rotate(0deg);
            transition: .5s ease-in-out;
            cursor: pointer;
        }

        .hamburger-icon span {
            display: block;
            position: absolute;
            height: 2px;
            width: 100%;
            background: #fff;
            border-radius: 2px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }

        .hamburger-icon span:nth-child(1) {
            top: 0px;
        }

        .hamburger-icon span:nth-child(2), .hamburger-icon span:nth-child(3) {
            top: 6px;
        }

        .hamburger-icon span:nth-child(4) {
            top: 12px;
        }

        .sidebar.collapsed .hamburger-icon span:nth-child(1) {
            top: 6px;
            width: 0%;
            left: 50%;
        }

        .sidebar.collapsed .hamburger-icon span:nth-child(2) {
            transform: rotate(45deg);
        }

        .sidebar.collapsed .hamburger-icon span:nth-child(3) {
            transform: rotate(-45deg);
        }

        .sidebar.collapsed .hamburger-icon span:nth-child(4) {
            top: 6px;
            width: 0%;
            left: 50%;
        }

        /* Mobile adjustments for sidebar toggle */
        @media (max-width: 768px) {
            .sidebar-toggle {
                top: 15px;
                right: auto;
                left: 15px;
                border: none;
                background-color: transparent;
                box-shadow: none;
            }

            .hamburger-icon span {
                background: #FF8000;
            }

            /* Show hamburger only when sidebar is not expanded on mobile */
            .sidebar:not(.expanded) + .main-content .mobile-hamburger {
                display: flex;
            }

            .sidebar.expanded .sidebar-toggle {
                right: auto;
                left: 205px;
            }

            .mobile-hamburger {
                display: none;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 999;
            }
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid #eee;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
        }

        .card-body {
            padding: 20px;
        }

        .action-button {
            background-color: #FF8000;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            display: inline-block;
        }

        .action-button:hover {
            background-color: #e67300;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background-color: #f8f9fa;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        .data-table td {
            padding: 12px;
            border-top: 1px solid #eee;
        }

        .data-table tr:hover {
            background-color: #f8f9fa;
        }

        .view-all {
            color: #FF8000;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }

        .status-ongoing {
            background-color: #D1ECF1;
            color: #0C5460;
        }

        .status-completed {
            background-color: #D4EDDA;
            color: #155724;
        }

        .status-low {
            background-color: #F8D7DA;
            color: #721C24;
        }

        .status-ok {
            background-color: #D4EDDA;
            color: #155724;
        }

        .action-links {
            display: flex;
            gap: 10px;
        }

        .btn-view, .btn-edit {
            color: #FF8000;
            text-decoration: none;
        }

        .btn-view:hover, .btn-edit:hover {
            color: #e67300;
        }

        @media (max-width: 992px) {
            .stats-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 20px 0;
                overflow: hidden;
            }

            .sidebar.collapsed {
                width: 0;
            }

            .sidebar.expanded {
                width: 250px;
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 0;
            }

            .sidebar-toggle {
                right: -15px;
            }

            .sidebar.expanded .sidebar-toggle {
                right: -15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="sidebar-toggle" id="sidebar-toggle">
                <div class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="logo-container">
                <div class="logo">
                    <!-- Logo image can be added here -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                        <polyline points="2 17 12 22 22 17"></polyline>
                        <polyline points="2 12 12 17 22 12"></polyline>
                    </svg>
                </div>
                <div class="logo-text">Rapid Concretech</div>
            </div>
            <nav class="menu">
                <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('projects.index') }}" class="menu-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                    <span>Projects</span>
                </a>

                <a href="{{ route('inventory.index') }}" class="menu-item {{ request()->routeIs('inventory.*') ? 'active' : '' }}">
                    <span>Inventory</span>
                </a>

                <a href="{{ route('suppliers.index') }}" class="menu-item {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                    <span>Suppliers</span>
                </a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="mobile-hamburger" id="mobile-hamburger">
                <div class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="content-header">
                <div class="datetime">
                    {{ now()->format('l, F j, Y') }}
                </div>
                <div class="user-dropdown">
                    <button class="user-dropdown-btn">
                        <svg class="user-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        {{ Auth::user()->name }}
                        <span class="position-badge">Inventory Staff</span>
                    </button>
                    <div class="user-dropdown-content">
                        <a href="#">Profile</a>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Toggle submenu visibility
        document.querySelectorAll('.menu-item').forEach(item => {
            if (item.querySelector('.arrow')) {
                item.addEventListener('click', event => {
                    const arrow = event.currentTarget.querySelector('.arrow');
                    arrow.classList.toggle('rotate');

                    const submenu = event.currentTarget.nextElementSibling;
                    if (submenu && submenu.classList.contains('submenu')) {
                        submenu.style.display = submenu.style.display === 'none' ? 'block' : 'none';
                    }
                });
            }
        });

        // Sidebar toggle functionality
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');

            if (window.innerWidth <= 768) {
                sidebar.classList.toggle('expanded');
            } else {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
            }
        });

        // Mobile hamburger menu toggle
        document.getElementById('mobile-hamburger')?.addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.add('expanded');
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');

            if (window.innerWidth <= 768) {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');

                if (!sidebar.classList.contains('expanded')) {
                    sidebar.style.width = '0';
                }
            } else {
                sidebar.classList.remove('expanded');
                if (sidebar.classList.contains('collapsed')) {
                    mainContent.classList.add('expanded');
                }
            }
        });
    </script>

    @yield('scripts')
</body>
</html>

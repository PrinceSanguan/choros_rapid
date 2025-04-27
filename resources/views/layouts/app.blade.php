<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Rapid Concretech') }}</title>
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }

        .sidebar {
            background-color: #FF8000;
            min-height: 100vh;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .sidebar-collapsed {
            padding-left: 0;
            padding-right: 0;
        }

        .sidebar .logo {
            text-align: center;
            color: #000;
            margin-bottom: 20px;
        }

        .sidebar .logo img {
            max-width: 80px;
            margin-bottom: 10px;
        }

        .sidebar .nav-link {
            color: #000;
            padding: 6px 15px;
            font-weight: bold;
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar .dropdown-menu {
            background-color: transparent;
            border: none;
            width: 100%;
            padding: 0;
            margin-top: 0;
            margin-bottom: 0;
            position: static;
            box-shadow: none;
            float: none;
            display: none; /* Hide by default */
        }

        .sidebar .dropdown-menu.show {
            display: block; /* Show when active */
        }

        .sidebar .dropdown-item {
            color: #000;
            padding: 4px 15px 4px 30px;
            white-space: normal;
            font-size: 14px;
        }

        .sidebar .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Remove dropdown arrow from Bootstrap */
        .sidebar .dropdown-toggle::after {
            display: none;
        }

        .sidebar .nav-item {
            width: 100%;
            margin-bottom: 5px;
        }

        /* Custom arrow indicator */
        .sidebar .arrow {
            transition: transform 0.3s;
        }

        .sidebar .arrow.down {
            transform: rotate(90deg);
        }

        /* Toggle button for mobile */
        #sidebarToggle {
            background-color: #FF8000;
            border: none;
            color: #000;
            padding: 10px;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 999;
            border-radius: 4px;
            display: none;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        /* Content area */
        #content {
            transition: all 0.3s;
            padding-left: 15px;
            padding-right: 15px;
        }

        /* Header area responsiveness */
        .header-date {
            color: #666;
            font-size: 14px;
            margin-right: 15px;
        }

        .user-dropdown {
            display: inline-block;
        }

        .user-dropdown-btn {
            background: none;
            border: none;
            color: #333;
            display: flex;
            align-items: center;
        }

        .user-dropdown-btn img {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            margin-right: 5px;
        }

        /* Responsive breakpoints */
        @media (max-width: 991px) {
            .header-date {
                font-size: 12px;
                margin-right: 10px;
            }
        }

        @media (max-width: 768px) {
            #sidebarToggle {
                display: block;
            }

            .sidebar {
                position: fixed;
                z-index: 998;
                left: -250px;
                width: 250px;
                padding-top: 60px;
            }

            .sidebar.show {
                left: 0;
            }

            #content {
                width: 100%;
                padding-left: 10px;
                padding-right: 10px;
                margin-left: 0;
            }

            .container {
                padding-left: 10px;
                padding-right: 10px;
            }

            .header-date {
                display: none;
            }

            /* Add padding to top to account for toggle button */
            body {
                padding-top: 10px;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-left: 5px;
                padding-right: 5px;
            }

            h2 {
                font-size: 1.5rem;
            }

            #content {
                padding-left: 5px;
                padding-right: 5px;
            }

            .user-dropdown-btn span {
                display: none;
            }
        }

        /* Overlay when sidebar is open on mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.4);
            z-index: 997;
        }

        .sidebar-overlay.show {
            display: block;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Mobile Toggle Button -->
    <button id="sidebarToggle" class="d-md-none">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="container-fluid px-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar" id="sidebar">
                <div class="logo">
                    <div class="text-center mb-2">
                        <div class="diamond-logo mb-2">
                            <img src="{{ asset('images/Rapid.jpg') }}" alt="Rapid Concretech" style="max-width: 80px;">
                        </div>
                    </div>
                    <h4>Rapid Concretech</h4>
                    <p>Dashboard</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin_dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#userManagementMenu">
                            User Management <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <ul class="dropdown-menu collapse" id="userManagementMenu">
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">— Manage Users</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.create') }}">— Add User</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#projectManagementMenu">
                            Project Management <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <ul class="dropdown-menu collapse" id="projectManagementMenu">
                            <li><a class="dropdown-item" href="{{ route('projects.create') }}">— Project Registration</a></li>
                            <li><a class="dropdown-item" href="{{ route('projects.index') }}">— Projects</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#billingMenu">
                            Billing Transaction <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <ul class="dropdown-menu collapse" id="billingMenu">
                            <li><a class="dropdown-item" href="{{ route('billings.create') }}">— Add Billing</a></li>
                            <li><a class="dropdown-item" href="{{ route('billings.index') }}">— Manage Billing</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#inventoryMenu">
                            Inventory <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <ul class="dropdown-menu collapse" id="inventoryMenu">
                            <li><a class="dropdown-item" href="{{ route('inventory.create') }}">— Add Product</a></li>
                            <li><a class="dropdown-item" href="{{ route('inventory.index') }}">— Manage Inventory</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#suppliersMenu">
                            Suppliers <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <ul class="dropdown-menu collapse" id="suppliersMenu">
                            <li><a class="dropdown-item" href="{{ route('supplier.create') }}">— Add Supplier</a></li>
                            <li><a class="dropdown-item" href="{{ route('supplier.index') }}">— Manage Suppliers</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#customerMenu">
                            Customer Data <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <ul class="dropdown-menu collapse" id="customerMenu">
                            <li><a class="dropdown-item" href="{{ route('customers.create') }}">— Add Customer</a></li>
                            <li><a class="dropdown-item" href="{{ route('customers.index') }}">— Manage Customer</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="collapse" data-bs-target="#reportsMenu">
                            Reports <i class="fas fa-chevron-right arrow"></i>
                        </a>
                        <ul class="dropdown-menu collapse" id="reportsMenu">
                            <li><a class="dropdown-item" href="{{ route('reports.weekly') }}">— Weekly Reports</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.monthly') }}">— Monthly Reports</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-10" id="content">
                <div class="container py-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0 mt-4">@yield('title')</h2>
                        <div class="d-flex align-items-center">
                            <span class="header-date">{{ \Carbon\Carbon::now()->format('F d, Y, h:i a') }}</span>
                            <div class="dropdown user-dropdown">
                                <button class="user-dropdown-btn dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <span>User</span>
                                    <i class="fas fa-user-circle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle arrow direction and add active class
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    const arrow = this.querySelector('.arrow');
                    arrow.classList.toggle('down');
                });
            });

            // Mobile sidebar toggle
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                    document.body.classList.toggle('sidebar-open');
                });
            }

            // Close sidebar when clicking on overlay
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                });
            }

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                }
            });

            // Close dropdown menus when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    const dropdownMenus = document.querySelectorAll('.dropdown-menu.show');
                    dropdownMenus.forEach(menu => {
                        const parent = menu.closest('.nav-item');
                        if (parent && !parent.contains(event.target)) {
                            menu.classList.remove('show');
                            const arrow = parent.querySelector('.arrow');
                            if (arrow) arrow.classList.remove('down');
                        }
                    });
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
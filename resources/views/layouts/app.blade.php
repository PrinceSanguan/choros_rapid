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
            display: none;
        }

        @media (max-width: 768px) {
            #sidebarToggle {
                display: block;
            }
            .sidebar {
                position: fixed;
                z-index: 998;
                left: -100%;
                width: 250px;
            }
            .sidebar.show {
                left: 0;
            }
            .col-md-10 {
                width: 100%;
            }
        }

        .dashboard-card {
            background-color: #f0ebe8;
            border-radius: 5px;
            padding: 15px;
            height: 200px;
            margin-bottom: 20px;
        }

        .calendar-card {
            background-color: #f0ebe8;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .calendar-header {
            background-color: #000;
            color: #fff;
            padding: 5px;
            text-align: center;
        }

        .calendar-table {
            width: 100%;
            margin-top: 10px;
        }

        .calendar-table td {
            text-align: center;
            padding: 5px;
        }

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
    </style>
    @yield('styles')
</head>
<body>
    <!-- Mobile Toggle Button -->
    <button id="sidebarToggle" class="d-md-none">
        <i class="fas fa-bars"></i>
    </button>

    <div class="container-fluid">
        <div class="row">
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
                        <h2>@yield('title')</h2>
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

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    const arrow = this.querySelector('.arrow');
                    arrow.classList.toggle('down');
                });
            });

            // Mobile sidebar toggle
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }

            // Close sidebar when clicking outside (mobile only)
            document.addEventListener('click', function(event) {
                if (window.innerWidth <= 768) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnToggle = sidebarToggle.contains(event.target);

                    if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html>

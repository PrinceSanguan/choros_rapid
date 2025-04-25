<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Rapid Concretech') }}</title>
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: #FF8000;
            min-height: 100vh;
            padding-top: 20px;
        }
        .sidebar .logo {
            text-align: center;
            color: #fff;
            margin-bottom: 20px;
        }
        .sidebar .logo img {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .sidebar .nav-link {
            color: #333;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .sidebar .dropdown-menu {
            background-color: #FFA64D;
            border: none;
            width: 100%;
            padding: 0;
        }
        .sidebar .dropdown-item {
            color: #333;
            padding: 10px 15px 10px 30px;
        }
        .sidebar .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        .dashboard-card {
            background-color: #f8f8f8;
            border-radius: 5px;
            padding: 15px;
            height: 200px;
            margin-bottom: 20px;
        }
        .calendar-card {
            background-color: #f8f8f8;
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="logo">
                    <div class="text-center mb-2">
                        <div class="diamond-logo mb-2">
                            <img src="{{ asset('logo.png') }}" alt="Rapid Concretech" onerror="this.src='data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22100%22%20height%3D%22100%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20100%20100%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_18c894ac2fb%20text%20%7B%20fill%3A%23000%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A10pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_18c894ac2fb%22%3E%3Crect%20width%3D%22100%22%20height%3D%22100%22%20fill%3D%22%23F8F9FA%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20transform%3D%22rotate(-45%2C%2030%2C%2030)%22%20x%3D%2230%22%20y%3D%2230%22%3ERapid%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E';">
                        </div>
                    </div>
                    <h4>Rapid Concretech</h4>
                    <p>Dashboard</p>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin_dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            User Management
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('users.index') }}">Manage Users</a></li>
                            <li><a class="dropdown-item" href="{{ route('users.create') }}">Add User</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Project Management
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('projects.create') }}">Project Registration</a></li>
                            <li><a class="dropdown-item" href="{{ route('projects.index') }}">Projects</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Billing Transaction
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('billings.create') }}">Add Billing</a></li>
                            <li><a class="dropdown-item" href="{{ route('billings.index') }}">Manage Billing</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Inventory
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('inventory.create') }}">Add Product</a></li>
                            <li><a class="dropdown-item" href="{{ route('inventory.index') }}">Manage Inventory</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Suppliers
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('suppliers.create') }}">Add Supplier</a></li>
                            <li><a class="dropdown-item" href="{{ route('suppliers.index') }}">Manage Suppliers</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Customer Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('customers.create') }}">Add Customer</a></li>
                            <li><a class="dropdown-item" href="{{ route('customers.index') }}">Manage Customer</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Reports
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('reports.weekly') }}">Weekly Reports</a></li>
                            <li><a class="dropdown-item" href="{{ route('reports.monthly') }}">Monthly Reports</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <div class="container py-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2>@yield('title')</h2>
                        <div>
                            <span class="me-3">{{ date('F d, Y, h:i a') }}</span>
                            <div class="dropdown d-inline-block">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name ?? 'User' }}
                                </button>
                                <ul class="dropdown-menu">
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
    @yield('scripts')
</body>
</html>

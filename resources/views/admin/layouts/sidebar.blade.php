<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rapid Concretech') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
            overflow-x: hidden;
        }

        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        /* Sidebar Styles */
        #sidebar {
            width: 250px;
            background-color: #FF8000;
            color: #000;
            transition: all 0.3s;
            min-height: 100vh;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            height: 100%;
            overflow-y: auto;
        }

        #sidebar.collapsed {
            margin-left: -250px;
            width: 250px;
        }

        .sidebar-header {
            padding: 15px;
            background-color: #FF8000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .logo {
            width: 40px;
            height: 40px;
            border-radius: 10%;
            margin-right: 10px;
        }

        .logo-text {
            font-weight: bold;
            font-size: 16px;
            color: #000;
        }

        .menu {
            padding: 0;
            list-style: none;
            margin-top: 15px;
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
            padding-left: 20px;
            display: none;
            background-color: rgba(255, 255, 255, 0.1);
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

        /* Enhanced Toggle Button */
        #sidebarCollapse {
            width: 32px;
            height: 32px;
            background: #FF8000;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            position: fixed;
            z-index: 1001;
            left: 215px;
            top: 20px;
            transition: all 0.3s;
        }

        #sidebar.collapsed ~ #content #sidebarCollapse {
            left: 30px; /* Adjust position when sidebar is collapsed */
        }

        #sidebarCollapse:hover {
            background: rgba(255, 128, 0, 0.8);
        }

        .hamburger-icon {
            width: 18px;
            height: 18px;
            position: relative;
            transform: rotate(0deg);
            transition: .5s ease-in-out;
        }

        .hamburger-icon span {
            display: block;
            position: absolute;
            height: 3px;
            width: 100%;
            background: #000;
            border-radius: 3px;
            opacity: 1;
            left: 0;
            transform: rotate(0deg);
            transition: .25s ease-in-out;
        }

        .hamburger-icon span:nth-child(1) {
            top: 0px;
        }

        .hamburger-icon span:nth-child(2) {
            top: 7px;
        }

        .hamburger-icon span:nth-child(3) {
            top: 14px;
        }

        #sidebarCollapse.active .hamburger-icon span:nth-child(1) {
            top: 7px;
            transform: rotate(135deg);
        }

        #sidebarCollapse.active .hamburger-icon span:nth-child(2) {
            opacity: 0;
            left: -60px;
        }

        #sidebarCollapse.active .hamburger-icon span:nth-child(3) {
            top: 7px;
            transform: rotate(-135deg);
        }

        /* Content Styles */
        #content {
            width: calc(100% - 250px);
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
            position: relative;
            margin-left: 250px;
        }

        #content.expanded {
            width: 100%;
            margin-left: 30px; /* Leave space for the visible part of sidebar */
        }

        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .header-container {
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
            margin-left: 20px;
        }

        /* Cards */
        .dashboard-grid .card {
            background-color: #f9f9f9;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            height: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .dashboard-grid .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .dashboard-grid .card-header {
            background-color: #f1f1f1;
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 15px;
        }

        .dashboard-grid .card-title {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
            text-transform: capitalize;
        }

        /* Calendar */
        .calendar-container {
            width: 100%;
        }

        .calendar-header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .month-year {
            font-size: 18px;
        }

        .calendar-table {
            width: 100%;
            border-collapse: collapse;
        }

        .calendar-table th, .calendar-table td {
            text-align: center;
            padding: 8px;
        }

        .calendar-table td {
            cursor: pointer;
        }

        .calendar-table td:hover {
            background-color: #eaeaea;
        }

        /* Metrics */
        .annual-metric {
            text-align: center;
        }

        .metric-value {
            font-size: 24px;
            font-weight: bold;
        }

        .progress-container {
            margin: 20px 0;
        }

        .progress {
            height: 20px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }

        .progress-bar {
            background-color: #4e73df;
            height: 100%;
        }

        .progress-value {
            text-align: center;
            margin-top: 5px;
            font-weight: bold;
        }

        .client-list, .area-list {
            list-style: none;
            padding: 0;
        }

        .client-item, .area-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .area-item {
            flex-direction: column;
        }

        .area-progress {
            margin-top: 5px;
        }

        .client-item:last-child, .area-item:last-child {
            border-bottom: none;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #6c757d;
        }

        /* User dropdown */
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

        /* Responsive styles */
        @media (max-width: 450px) {
            #sidebar {
                margin-left: -220px;  /* Show a small portion instead of completely hiding */
                left: -40px; /* Offset the sidebar on mobile screens */
            }
            #sidebar.collapsed {
                margin-left: 40px;
            }
            #content {
                width: 100%;
                margin-left: 30px;
            }
            #content.expanded {
                width: calc(100% - 250px);
                margin-left: 250px;
            }
            #sidebarCollapse {
                left: 30px;
            }
            #sidebar.collapsed ~ #content #sidebarCollapse {
                left: 210px;
            }
            .calendar-table th, .calendar-table td {
                padding: 5px;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 767.98px) {
            .desktop-header {
                display: none;
            }
            .mobile-header {
                display: flex !important;
            }
            .calendar-table th, .calendar-table td {
                padding: 3px;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 575.98px) {
            .calendar-table th, .calendar-table td {
                padding: 2px;
                font-size: 0.7rem;
            }
        }

        .mobile-header {
            display: none;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/Rapid.jpg') }}" alt="Rapid Concretech Logo" class="logo">
                    <div class="logo-text">Rapid Concretech</div>
                </div>
            </div>

            <div class="menu">
                <a href="{{ route('admin_dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span><i class="fas fa-tachometer-alt me-2"></i> Dashboard</span>
                </a>

                <div class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <span><i class="fas fa-users me-2"></i> User Management</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu" style="display: {{ request()->routeIs('users.*') ? 'block' : 'none' }}">
                    <a href="{{ route('users.index') }}" class="submenu-item">Manage Users</a>
                    <a href="{{ route('users.create') }}" class="submenu-item">Add Users</a>
                </div>

                <div class="menu-item {{ request()->routeIs('projects.*') ? 'active' : '' }}">
                    <span><i class="fas fa-project-diagram me-2"></i> Project Management</span>
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu" style="display: {{ request()->routeIs('projects.*') ? 'block' : 'none' }}">
                    <a href="{{ route('projects.index') }}" class="submenu-item">All Projects</a>
                    @if(auth()->check() && auth()->user()->hasRole('project-manager'))
                        <a href="{{ route('projects.registration') }}" class="submenu-item">Project Registration</a>
                    @endif
                    @if(auth()->check() && auth()->user()->hasRole('admin'))
                        <a href="{{ route('projects.create') }}" class="submenu-item">Add Project</a>
                    @endif
                </div>

                <div class="menu-item">
                    <span><i class="fas fa-file-invoice-dollar me-2"></i> Billing Transaction</span>
                    <span class="arrow">▼</span>
                </div>

                <div class="menu-item">
                    <span><i class="fas fa-boxes me-2"></i> Inventory</span>
                    <span class="arrow">▼</span>
                </div>

                <div class="menu-item">
                    <span><i class="fas fa-truck me-2"></i> Suppliers</span>
                    <span class="arrow">▼</span>
                </div>

                <div class="menu-item">
                    <span><i class="fas fa-user-tie me-2"></i> Customer Data</span>
                    <span class="arrow">▼</span>
                </div>

                <div class="menu-item">
                    <span><i class="fas fa-chart-bar me-2"></i> Reports</span>
                    <span class="arrow">▼</span>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Toggle Button -->
            <button type="button" id="sidebarCollapse" class="active">
                <div class="hamburger-icon">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>

            <!-- Header -->
            <div class="header-container desktop-header">
                <div class="d-flex align-items-center">
                    <div class="datetime">
                        {{ now()->format('F j, Y, g:i a') }}
                    </div>
                </div>

                <div class="user-dropdown">
                    <button class="user-dropdown-btn">
                        <svg class="user-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                        </svg>
                        {{ auth()->user()->name }} <span class="position-badge">{{ ucfirst(auth()->user()->position) }}</span> ▼
                    </button>
                    <div class="user-dropdown-content">
                        <a href="#"><i class="fas fa-user me-2"></i> Profile</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile Header -->
            <div class="header-container mobile-header">
                <div class="d-flex align-items-center">
                    <span class="fw-bold ms-2">Rapid Concretech</span>
                </div>

                <div class="user-dropdown">
                    <button class="user-dropdown-btn">
                        <i class="fas fa-user-circle"></i>
                    </button>
                    <div class="user-dropdown-content">
                        <a href="#"><i class="fas fa-user me-2"></i> Profile</a>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="content-header">
                <h2>Dashboard</h2>
            </div>

            <!-- Dashboard Grid Layout -->
            <div class="dashboard-grid">
                <!-- Four Cards in 1 row -->
                <div class="row g-3">
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card shadow h-100">
                            <div class="card-header">
                                <h5 class="card-title">Area of accomplishment</h5>
                            </div>
                            <div class="card-body">
                                <div class="area-chart">
                                    <div class="chart-container">
                                        <ul class="area-list">
                                            <li class="area-item">
                                                <div class="area-name">Design</div>
                                                <div class="area-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 85%"></div>
                                                    </div>
                                                    <div class="progress-value">85%</div>
                                                </div>
                                            </li>
                                            <li class="area-item">
                                                <div class="area-name">Construction</div>
                                                <div class="area-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 70%"></div>
                                                    </div>
                                                    <div class="progress-value">70%</div>
                                                </div>
                                            </li>
                                            <li class="area-item">
                                                <div class="area-name">Planning</div>
                                                <div class="area-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 90%"></div>
                                                    </div>
                                                    <div class="progress-value">90%</div>
                                                </div>
                                            </li>
                                            <li class="area-item">
                                                <div class="area-name">Implementation</div>
                                                <div class="area-progress">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 65%"></div>
                                                    </div>
                                                    <div class="progress-value">65%</div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card shadow h-100">
                            <div class="card-header">
                                <h5 class="card-title">Total Annual For Week(Sale)</h5>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="annual-metric">
                                    <div class="metric-value">0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card shadow h-100">
                            <div class="card-header">
                                <h5 class="card-title">Top-Tier Purchase Client</h5>
                            </div>
                            <div class="card-body">
                                <div class="top-clients">
                                    <div class="no-data">No client data available</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <div class="card shadow h-100">
                            <div class="card-header">
                                <h5 class="card-title">Total Annual For Month(Sale)</h5>
                            </div>
                            <div class="card-body d-flex align-items-center justify-content-center">
                                <div class="annual-metric">
                                    <div class="metric-value">0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Calendar Row -->
                <div class="row g-3 mt-3">
                    <div class="col-12 col-lg-6">
                        <div class="card shadow h-100">
                            <div class="card-header">
                                <h5 class="card-title">Calendar for schedules</h5>
                            </div>
                            <div class="card-body">
                                <div class="calendar-container">
                                    <div class="calendar-header">
                                        <div class="month-year">APRIL 2025</div>
                                    </div>
                                    <table class="calendar-table">
                                        <thead>
                                            <tr>
                                                <th>S</th>
                                                <th>M</th>
                                                <th>T</th>
                                                <th>W</th>
                                                <th>T</th>
                                                <th>F</th>
                                                <th>S</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>1</td>
                                                <td>2</td>
                                                <td>3</td>
                                                <td>4</td>
                                                <td>5</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>7</td>
                                                <td>8</td>
                                                <td>9</td>
                                                <td>10</td>
                                                <td>11</td>
                                                <td>12</td>
                                            </tr>
                                            <tr>
                                                <td>13</td>
                                                <td>14</td>
                                                <td>15</td>
                                                <td>16</td>
                                                <td>17</td>
                                                <td>18</td>
                                                <td>19</td>
                                            </tr>
                                            <tr>
                                                <td>20</td>
                                                <td>21</td>
                                                <td>22</td>
                                                <td>23</td>
                                                <td>24</td>
                                                <td class="bg-warning text-dark">25</td>
                                                <td>26</td>
                                            </tr>
                                            <tr>
                                                <td>27</td>
                                                <td>28</td>
                                                <td>29</td>
                                                <td>30</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card shadow h-100">
                            <div class="card-header">
                                <h5 class="card-title">Accomplishment of project</h5>
                            </div>
                            <div class="card-body">
                                <div class="accomplishment-chart">
                                    <div class="progress-container">
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <div class="progress-value">0%</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar toggle
            document.getElementById('sidebarCollapse').addEventListener('click', function () {
                document.getElementById('sidebar').classList.toggle('collapsed');
                document.getElementById('content').classList.toggle('expanded');
                this.classList.toggle('active');
            });

            // Menu item click to show/hide submenu
            document.querySelectorAll('.menu-item').forEach(function(item) {
                if (item.querySelector('.arrow')) {
                    item.addEventListener('click', function(e) {
                        e.preventDefault();
                        const arrow = this.querySelector('.arrow');
                        arrow.classList.toggle('rotate');
                        const submenu = this.nextElementSibling;
                        if (submenu && submenu.classList.contains('submenu')) {
                            if (submenu.style.display === 'block') {
                                submenu.style.display = 'none';
                            } else {
                                submenu.style.display = 'block';
                            }
                        }
                    });
                }
            });

            // Initialize submenus based on active state
            document.querySelectorAll('.submenu').forEach(function(submenu) {
                if (submenu.querySelector('.submenu-item.active')) {
                    submenu.style.display = 'block';
                    const menuItem = submenu.previousElementSibling;
                    if (menuItem) {
                        const arrow = menuItem.querySelector('.arrow');
                        if (arrow) {
                            arrow.classList.add('rotate');
                        }
                    }
                }
            });

            // On smaller screens, collapse sidebar by default
            function checkWidth() {
                if (window.innerWidth < 992) {
                    document.getElementById('sidebar').classList.add('collapsed');
                    document.getElementById('content').classList.add('expanded');
                    document.getElementById('sidebarCollapse').classList.remove('active');
                } else {
                    document.getElementById('sidebar').classList.remove('collapsed');
                    document.getElementById('content').classList.remove('expanded');
                    document.getElementById('sidebarCollapse').classList.add('active');
                }
            }

            // Check width when page loads
            checkWidth();

            // Check width when window is resized
            window.addEventListener('resize', checkWidth);
        });
    </script>
</body>
</html>

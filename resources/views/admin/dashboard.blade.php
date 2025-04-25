<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - Rapid Concretech</title>

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

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .dashboard-card {
            background-color: #f0ebe8;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #000;
        }

        .calendar {
            width: 100%;
            text-align: center;
        }

        .calendar-header {
            background-color: #000;
            color: #fff;
            padding: 8px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .calendar-body {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .calendar-day {
            padding: 5px;
            text-align: center;
        }

        .calendar-day.header {
            font-weight: bold;
        }

        .calendar-day.today {
            background-color: #FF8000;
            border-radius: 50%;
            color: #fff;
        }

        .annual-stats {
            font-size: 24px;
            font-weight: bold;
            margin-top: 10px;
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
                <a href="{{ route('admin_dashboard') }}" class="menu-item active">Dashboard</a>

                <div class="menu-item">
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
                <div class="submenu" style="display: none;">
                    <a href="{{ route('projects.index') }}" class="submenu-item">Manage Projects</a>
                    <a href="{{ route('projects.create') }}" class="submenu-item">Add Project</a>
                </div>

                <div class="menu-item">
                    Billing Transaction
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu" style="display: none;">
                    <a href="{{ route('billings.index') }}" class="submenu-item">Manage Billings</a>
                    <a href="{{ route('billings.create') }}" class="submenu-item">Create Invoice</a>
                </div>

                <div class="menu-item">
                    Inventory
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu" style="display: none;">
                    <a href="{{ route('inventory.index') }}" class="submenu-item">Manage Inventory</a>
                    <a href="{{ route('inventory.create') }}" class="submenu-item">Add Items</a>
                </div>

                <div class="menu-item">
                    Suppliers
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu" style="display: none;">
                    <a href="{{ route('suppliers.index') }}" class="submenu-item">Manage Suppliers</a>
                    <a href="{{ route('suppliers.create') }}" class="submenu-item">Add Supplier</a>
                </div>

                <div class="menu-item">
                    Customer Data
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu" style="display: none;">
                    <a href="{{ route('customers.index') }}" class="submenu-item">Manage Customers</a>
                    <a href="{{ route('customers.create') }}" class="submenu-item">Add Customer</a>
                </div>

                <div class="menu-item">
                    Reports
                    <span class="arrow">▼</span>
                </div>
                <div class="submenu" style="display: none;">
                    <a href="{{ route('reports.weekly') }}" class="submenu-item">Weekly Reports</a>
                    <a href="{{ route('reports.monthly') }}" class="submenu-item">Monthly Reports</a>
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
                        {{ Auth::user()->name }} ▼
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

            <div class="content-title">Admin Dashboard</div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Calendar Card -->
                <div class="dashboard-card">
                    <div class="card-title">Calendar for schedules</div>
                    <div class="calendar">
                        <div class="calendar-header">
                            APRIL 2025
                        </div>
                        <div class="calendar-body">
                            <div class="calendar-day header">S</div>
                            <div class="calendar-day header">M</div>
                            <div class="calendar-day header">T</div>
                            <div class="calendar-day header">W</div>
                            <div class="calendar-day header">T</div>
                            <div class="calendar-day header">F</div>
                            <div class="calendar-day header">S</div>

                            <div class="calendar-day"></div>
                            <div class="calendar-day">1</div>
                            <div class="calendar-day">2</div>
                            <div class="calendar-day">3</div>
                            <div class="calendar-day">4</div>
                            <div class="calendar-day">5</div>
                            <div class="calendar-day">6</div>

                            <div class="calendar-day">7</div>
                            <div class="calendar-day">8</div>
                            <div class="calendar-day">9</div>
                            <div class="calendar-day">10</div>
                            <div class="calendar-day">11</div>
                            <div class="calendar-day">12</div>
                            <div class="calendar-day">13</div>

                            <div class="calendar-day">14</div>
                            <div class="calendar-day">15</div>
                            <div class="calendar-day today">16</div>
                            <div class="calendar-day">17</div>
                            <div class="calendar-day">18</div>
                            <div class="calendar-day">19</div>
                            <div class="calendar-day">20</div>

                            <div class="calendar-day">21</div>
                            <div class="calendar-day">22</div>
                            <div class="calendar-day">23</div>
                            <div class="calendar-day">24</div>
                            <div class="calendar-day">25</div>
                            <div class="calendar-day">26</div>
                            <div class="calendar-day">27</div>

                            <div class="calendar-day">28</div>
                            <div class="calendar-day">29</div>
                            <div class="calendar-day">30</div>
                            <div class="calendar-day"></div>
                            <div class="calendar-day"></div>
                            <div class="calendar-day"></div>
                            <div class="calendar-day"></div>
                        </div>
                    </div>
                </div>

                <!-- Weekly Annual Sales Card -->
                <div class="dashboard-card">
                    <div class="card-title">total annual for week(sale)</div>
                    <div class="annual-stats">
                        ₱{{ number_format($weeklyAnnualSale, 2) }}
                    </div>
                </div>

                <!-- Project Accomplishment Card -->
                <div class="dashboard-card">
                    <div class="card-title">Accomplishment of project</div>
                    <div style="height: 100px; position: relative;">
                        <div style="width: 100%; background-color: #e0e0e0; height: 20px; border-radius: 10px; position: relative; margin-top: 20px;">
                            <div style="width: {{ $projectAccomplishment }}%; background-color: #FF8000; height: 20px; border-radius: 10px;">
                            </div>
                            <div style="position: absolute; top: 0; right: 10px;">
                                {{ $projectAccomplishment }}%
                            </div>
                        </div>
                        <div style="margin-top: 10px;">
                            <small>{{ $completedProjects }} completed out of {{ $totalProjects }} projects</small>
                        </div>
                    </div>
                </div>

                <!-- Monthly Annual Sales Card -->
                <div class="dashboard-card">
                    <div class="card-title">total annual for month(sale)</div>
                    <div class="annual-stats">
                        ₱{{ number_format($monthlyAnnualSale, 2) }}
                    </div>
                </div>
            </div>

            <!-- Second Row Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Area of Accomplishment Card -->
                <div class="dashboard-card">
                    <div class="card-title">Area of Accomplishment</div>
                    <div style="padding: 10px 0;">
                        @foreach ($areaAccomplishment as $area => $percentage)
                        <div style="margin-bottom: 10px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                <span>{{ ucfirst(str_replace('_', ' ', $area)) }}</span>
                                <span>{{ $percentage }}%</span>
                            </div>
                            <div style="width: 100%; background-color: #e0e0e0; height: 8px; border-radius: 4px;">
                                <div style="width: {{ $percentage }}%; background-color: #FF8000; height: 8px; border-radius: 4px;"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Weekly Annual Sales Card (Repeated for layout) -->
                <div class="dashboard-card">
                    <div class="card-title">total annual for week(sale)</div>
                    <div class="annual-stats">
                        ₱{{ number_format($weeklyAnnualSale, 2) }}
                    </div>
                </div>

                <!-- Top Tier Purchase Client Card -->
                <div class="dashboard-card">
                    <div class="card-title">Top-tier Purchase Client</div>
                    <div style="padding: 10px 0;">
                        @if(count($topClients) > 0)
                            @foreach($topClients as $index => $client)
                                <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                                    <span>{{ $index + 1 }}. {{ $client->name }}</span>
                                    <span>₱{{ number_format($client->total_purchase, 2) }}</span>
                                </div>
                            @endforeach
                        @else
                            <p>No client data available</p>
                        @endif
                    </div>
                </div>

                <!-- Monthly Annual Sales Card (Repeated for layout) -->
                <div class="dashboard-card">
                    <div class="card-title">total annual for month(sale)</div>
                    <div class="annual-stats">
                        ₱{{ number_format($monthlyAnnualSale, 2) }}
                    </div>
                </div>
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
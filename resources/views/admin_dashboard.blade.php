<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - Rapid Concretech</title>

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

        /* Dashboard widgets */
        .dashboard-widgets {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .widget {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            min-height: 200px;
        }

        .widget-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #333;
        }

        /* Calendar styles */
        .calendar {
            width: 100%;
            border-collapse: collapse;
        }

        .calendar th {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .calendar td {
            width: 14.28%;
            text-align: center;
            padding: 8px;
            border: 1px solid #ddd;
        }

        .calendar .month-header {
            background-color: #444;
            color: white;
            font-weight: 600;
            text-align: center;
            padding: 10px;
        }

        /* Stats widgets */
        .stats-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stat-box {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 15px;
            width: 23%;
            text-align: center;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            margin: 10px 0;
            color: #FF8000;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
        }

        /* Links */
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
                <div class="content-title">Dashboard</div>

                <!-- Stats Overview -->
                <div class="stats-container">
                    <div class="stat-box">
                        <div class="stat-number">{{ $projectsCount ?? 0 }}</div>
                        <div class="stat-label">Total Projects</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">₱{{ number_format($weeklyIncome ?? 0, 2) }}</div>
                        <div class="stat-label">Weekly Income</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">₱{{ number_format($monthlyIncome ?? 0, 2) }}</div>
                        <div class="stat-label">Monthly Income</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number">{{ $lowStockItems ?? 0 }}</div>
                        <div class="stat-label">Low Stock Items</div>
                    </div>
                </div>

                <!-- Dashboard Widgets -->
                <div class="dashboard-widgets">
                    <!-- Calendar Widget -->
                    <div class="widget">
                        <div class="widget-title">Calendar for schedules</div>
                        <table class="calendar">
                            <thead>
                                <tr>
                                    <th colspan="7" class="month-header">APRIL 2025</th>
                                </tr>
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
                                    <td>25</td>
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

                    <!-- Weekly Sales Stats -->
                    <div class="widget">
                        <div class="widget-title">Total annual for week(sale)</div>
                        <div style="padding: 20px; text-align: center; font-size: 22px; font-weight: bold;">
                            ₱{{ number_format($weeklyIncome ?? 125000, 2) }}
                        </div>
                    </div>

                    <!-- Project Accomplishment -->
                    <div class="widget">
                        <div class="widget-title">Accomplishment of project</div>
                        <div style="padding: 10px;">
                            @foreach($recentProjects ?? [] as $project)
                                <div style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                                    <div style="font-weight: 600;">{{ $project->name ?? 'Project Name' }}</div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                        <span>Progress:</span>
                                        <span>{{ $project->progress ?? '65' }}%</span>
                                    </div>
                                    <div style="height: 8px; background-color: #eee; border-radius: 4px; margin-top: 5px;">
                                        <div style="height: 100%; width: {{ $project->progress ?? '65' }}%; background-color: #FF8000; border-radius: 4px;"></div>
                                    </div>
                                </div>
                            @endforeach

                            @if(empty($recentProjects ?? []))
                                <div style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                                    <div style="font-weight: 600;">ABC Tower Construction</div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                        <span>Progress:</span>
                                        <span>65%</span>
                                    </div>
                                    <div style="height: 8px; background-color: #eee; border-radius: 4px; margin-top: 5px;">
                                        <div style="height: 100%; width: 65%; background-color: #FF8000; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #eee;">
                                    <div style="font-weight: 600;">Green Heights Residential</div>
                                    <div style="display: flex; justify-content: space-between; margin-top: 5px;">
                                        <span>Progress:</span>
                                        <span>89%</span>
                                    </div>
                                    <div style="height: 8px; background-color: #eee; border-radius: 4px; margin-top: 5px;">
                                        <div style="height: 100%; width: 89%; background-color: #FF8000; border-radius: 4px;"></div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Monthly Sales Stats -->
                    <div class="widget">
                        <div class="widget-title">Total annual for month (sale)</div>
                        <div style="padding: 20px; text-align: center; font-size: 22px; font-weight: bold;">
                            ₱{{ number_format($monthlyIncome ?? 542000, 2) }}
                        </div>
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

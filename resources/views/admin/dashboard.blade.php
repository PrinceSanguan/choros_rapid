@extends('admin.layouts.sidebar')

@section('content')
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
                        @if(isset($areaAccomplishment))
                            <div class="chart-container">
                                <ul class="area-list">
                                    @foreach($areaAccomplishment as $area => $value)
                                    <li class="area-item">
                                        <div class="area-name">{{ ucfirst(str_replace('_', ' ', $area)) }}</div>
                                        <div class="area-progress">
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $value }}%"></div>
                                            </div>
                                            <div class="progress-value">{{ $value }}%</div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="no-data">No area data available</div>
                        @endif
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
                        @if(isset($topClients) && count($topClients) > 0)
                            <ul class="client-list">
                                @foreach($topClients as $client)
                                <li class="client-item">
                                    <div class="client-name">{{ $client->name }}</div>
                                    <div class="client-value">{{ $client->total_purchase }}</div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="no-data">No client data available</div>
                        @endif
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
@endsection

@section('styles')
<style>
    /* Dashboard-specific styles */
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

    /* Responsive styles */
    @media (max-width: 991.98px) {
        .calendar-table th, .calendar-table td {
            padding: 5px;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 767.98px) {
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
</style>
@endsection
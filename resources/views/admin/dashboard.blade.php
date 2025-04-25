@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <!-- First Row -->
    <div class="col-md-6">
        <div class="calendar-card">
            <h5>Calendar for schedules</h5>
            <div class="calendar-header">
                APRIL 2025
            </div>
            <table class="calendar-table">
                <thead>
                    <tr>
                        <td>S</td>
                        <td>M</td>
                        <td>T</td>
                        <td>W</td>
                        <td>T</td>
                        <td>F</td>
                        <td>S</td>
                    </tr>
                </thead>
                <tbody>
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
    </div>
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Total annual for week(sale)</h5>
            <canvas id="weekSalesChart"></canvas>
        </div>
    </div>
</div>

<div class="row">
    <!-- Second Row -->
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Accomplishment of project</h5>
            <canvas id="projectAccomplishmentChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Total annual for month (sale)</h5>
            <canvas id="monthSalesChart"></canvas>
        </div>
    </div>
</div>

<div class="row">
    <!-- Third Row -->
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Area of accomplishment</h5>
            <canvas id="areaAccomplishmentChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Top-tier Purchase Client</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Client</th>
                            <th>Total Purchase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topClients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>₱{{ number_format($client->total_purchase, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Weekly Sales Chart
    const weekCtx = document.getElementById('weekSalesChart').getContext('2d');
    const weekSalesChart = new Chart(weekCtx, {
        type: 'bar',
        data: {
            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
            datasets: [{
                label: 'Weekly Sales',
                data: [{{ $weeklyAnnualSale ?? 10000 }}, {{ ($weeklyAnnualSale ?? 10000) * 0.8 }}, {{ ($weeklyAnnualSale ?? 10000) * 1.2 }}, {{ ($weeklyAnnualSale ?? 10000) * 0.9 }}],
                backgroundColor: 'rgba(255, 128, 0, 0.7)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Monthly Sales Chart
    const monthCtx = document.getElementById('monthSalesChart').getContext('2d');
    const monthSalesChart = new Chart(monthCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Monthly Sales',
                data: [
                    {{ ($monthlyAnnualSale ?? 40000) * 0.7 }},
                    {{ ($monthlyAnnualSale ?? 40000) * 0.8 }},
                    {{ ($monthlyAnnualSale ?? 40000) * 0.9 }},
                    {{ $monthlyAnnualSale ?? 40000 }},
                    {{ ($monthlyAnnualSale ?? 40000) * 1.1 }},
                    {{ ($monthlyAnnualSale ?? 40000) * 1.2 }},
                    {{ ($monthlyAnnualSale ?? 40000) * 1.3 }},
                    {{ ($monthlyAnnualSale ?? 40000) * 1.2 }},
                    {{ ($monthlyAnnualSale ?? 40000) * 1.1 }},
                    {{ $monthlyAnnualSale ?? 40000 }},
                    {{ ($monthlyAnnualSale ?? 40000) * 0.9 }},
                    {{ ($monthlyAnnualSale ?? 40000) * 0.8 }}
                ],
                backgroundColor: 'rgba(255, 128, 0, 0.2)',
                borderColor: 'rgba(255, 128, 0, 1)',
                borderWidth: 2,
                fill: true
            }]
        }
    });

    // Project Accomplishment Chart
    const projectCtx = document.getElementById('projectAccomplishmentChart').getContext('2d');
    const projectAccomplishmentChart = new Chart(projectCtx, {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Ongoing', 'Pending'],
            datasets: [{
                data: [{{ $completedProjects ?? 5 }}, {{ $ongoingProjects ?? 3 }}, {{ $pendingProjects ?? 2 }}],
                backgroundColor: [
                    'rgba(0, 200, 0, 0.7)',
                    'rgba(255, 128, 0, 0.7)',
                    'rgba(200, 200, 200, 0.7)'
                ],
                borderWidth: 1
            }]
        }
    });

    // Area Accomplishment Chart
    const areaCtx = document.getElementById('areaAccomplishmentChart').getContext('2d');
    const areaData = {!! isset($areaAccomplishment) ? json_encode($areaAccomplishment) : json_encode(['design' => 85, 'construction' => 70, 'planning' => 90, 'implementation' => 65]) !!};

    const areaAccomplishmentChart = new Chart(areaCtx, {
        type: 'radar',
        data: {
            labels: Object.keys(areaData),
            datasets: [{
                label: 'Accomplishment %',
                data: Object.values(areaData),
                backgroundColor: 'rgba(255, 128, 0, 0.2)',
                borderColor: 'rgba(255, 128, 0, 1)',
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                r: {
                    min: 0,
                    max: 100
                }
            }
        }
    });
</script>
@endsection

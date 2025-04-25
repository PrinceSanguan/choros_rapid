@extends('layouts.app')

@section('title', 'Monthly Reports')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Monthly Summary</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Monthly Income</h5>
                                <h2>₱{{ number_format($monthlyIncome ?? 0, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">
                                <h5 class="card-title">New Projects</h5>
                                <h2>{{ $monthlyProjects ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white mb-3">
                            <div class="card-body">
                                <h5 class="card-title">New Customers</h5>
                                <h2>{{ $monthlyNewCustomers ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5>Weekly Revenue (This Month)</h5>
            </div>
            <div class="card-body">
                <canvas id="weeklyRevenueChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Weekly Summary</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Week</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($weeklyStats ?? [] as $stat)
                            <tr>
                                <td>Week {{ $stat->week }}</td>
                                <td>₱{{ number_format($stat->total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Weekly Revenue Chart
const weeklyCtx = document.getElementById('weeklyRevenueChart').getContext('2d');
const weeklyLabels = {!! json_encode($weeklyStats->pluck('week')->map(function($week) {
    return 'Week ' . $week;
})) ?? '[]' !!};
const weeklyData = {!! json_encode($weeklyStats->pluck('total')) ?? '[]' !!};

const weeklyRevenueChart = new Chart(weeklyCtx, {
    type: 'bar',
    data: {
        labels: weeklyLabels,
        datasets: [{
            label: 'Weekly Revenue',
            data: weeklyData,
            backgroundColor: 'rgba(255, 128, 0, 0.7)',
            borderColor: 'rgba(255, 128, 0, 1)',
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
</script>
@endsection

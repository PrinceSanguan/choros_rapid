@extends('layouts.app')

@section('title', 'Weekly Reports')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5>Weekly Summary</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white mb-3">
                            <div class="card-body">
                                <h5 class="card-title">Weekly Income</h5>
                                <h2>₱{{ number_format($weeklyIncome ?? 0, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white mb-3">
                            <div class="card-body">
                                <h5 class="card-title">New Projects</h5>
                                <h2>{{ $weeklyProjects ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white mb-3">
                            <div class="card-body">
                                <h5 class="card-title">New Customers</h5>
                                <h2>{{ $weeklyNewCustomers ?? 0 }}</h2>
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
                <h5>Daily Revenue (This Week)</h5>
            </div>
            <div class="card-body">
                <canvas id="dailyRevenueChart" height="300"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Recent Transactions</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dailyStats ?? [] as $stat)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($stat->date)->format('M d, Y') }}</td>
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
// Daily Revenue Chart
const dailyCtx = document.getElementById('dailyRevenueChart').getContext('2d');
const dailyLabels = {!! json_encode($dailyStats->pluck('date')->map(function($date) {
    return \Carbon\Carbon::parse($date)->format('D, M d');
})) ?? '[]' !!};
const dailyData = {!! json_encode($dailyStats->pluck('total')) ?? '[]' !!};

const dailyRevenueChart = new Chart(dailyCtx, {
    type: 'bar',
    data: {
        labels: dailyLabels,
        datasets: [{
            label: 'Daily Revenue',
            data: dailyData,
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

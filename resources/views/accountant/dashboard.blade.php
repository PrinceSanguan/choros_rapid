@extends('layouts.app')

@section('title', 'Accountant Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            Welcome to the Accountant Dashboard. Financial data and billing information will be displayed here.
        </div>
    </div>
</div>

<div class="row">
    <!-- First Row -->
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Total annual for week(sale)</h5>
            <canvas id="weekSalesChart"></canvas>
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
    <!-- Second Row -->
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
                            <th>Total Paid</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topClients ?? [] as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>₱{{ number_format($client->total_paid ?? 0, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Supplier Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            Welcome to the Supplier Dashboard. Your supplies and order information will be displayed here.
        </div>
    </div>
</div>

<div class="row">
    <!-- First Row -->
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Recent Orders</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Items</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ORD-001</td>
                            <td>5</td>
                            <td>2025-04-20</td>
                            <td>Delivered</td>
                        </tr>
                        <tr>
                            <td>ORD-002</td>
                            <td>3</td>
                            <td>2025-04-22</td>
                            <td>Pending</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Supply Items</h5>
            <canvas id="supplyItemsChart"></canvas>
        </div>
    </div>
</div>

<div class="row">
    <!-- Second Row -->
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Monthly Performance</h5>
            <canvas id="performanceChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Notifications</h5>
            <ul class="list-group">
                <li class="list-group-item">New order request - 2025-04-24</li>
                <li class="list-group-item">Delivery confirmation needed - 2025-04-23</li>
                <li class="list-group-item">Payment received - 2025-04-21</li>
            </ul>
        </div>
    </div>
</div>
@endsection

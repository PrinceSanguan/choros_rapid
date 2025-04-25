@extends('layouts.app')

@section('title', 'Inventory Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            Welcome to the Inventory Dashboard. Stock levels and inventory management will be displayed here.
        </div>
    </div>
</div>

<div class="row">
    <!-- First Row -->
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Low Stock Items</h5>
            <canvas id="lowStockChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Inventory by Category</h5>
            <canvas id="inventoryCategoryChart"></canvas>
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
            <h5>Recent Stock Movements</h5>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Movement</th>
                            <th>Quantity</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sample Item 1</td>
                            <td>In</td>
                            <td>50</td>
                            <td>2025-04-20</td>
                        </tr>
                        <tr>
                            <td>Sample Item 2</td>
                            <td>Out</td>
                            <td>20</td>
                            <td>2025-04-22</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

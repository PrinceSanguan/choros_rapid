@extends('layouts.app')

@section('title', 'Project Manager Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            Welcome to the Project Manager Dashboard. Your projects and tasks will be displayed here.
        </div>
    </div>
</div>

<div class="row">
    <!-- First Row -->
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Accomplishment of project</h5>
            <canvas id="projectAccomplishmentChart"></canvas>
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
            <h5>Area of accomplishment</h5>
            <canvas id="areaAccomplishmentChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Total annual for month (sale)</h5>
            <canvas id="monthSalesChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Charts code similar to admin dashboard but with project manager data
    // ...
</script>
@endsection

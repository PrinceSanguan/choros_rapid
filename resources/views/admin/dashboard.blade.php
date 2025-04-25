@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="row">
    <!-- First Row -->
    <div class="col-md-6">
        <div class="dashboard-card" style="height: auto;">
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
    </div>
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>total annual for week(sale)</h5>
            <div class="annual-stats mt-3">
                ₱{{ number_format($weeklyAnnualSale ?? 10000, 2) }}
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Second Row -->
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Accomplishment of project</h5>
            <div class="progress mt-4" style="height: 24px;">
                <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $projectAccomplishment ?? 75 }}%;" aria-valuenow="{{ $projectAccomplishment ?? 75 }}" aria-valuemin="0" aria-valuemax="100">{{ $projectAccomplishment ?? 75 }}%</div>
            </div>
            <p class="mt-3">{{ $completedProjects ?? 5 }} completed out of {{ $totalProjects ?? 10 }} projects</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>total annual for month (sale)</h5>
            <div class="annual-stats mt-3">
                ₱{{ number_format($monthlyAnnualSale ?? 40000, 2) }}
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Third Row -->
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Area of accomplishment</h5>
            <div class="mt-3">
                @php
                    $areas = isset($areaAccomplishment) ? $areaAccomplishment : ['design' => 85, 'construction' => 70, 'planning' => 90, 'implementation' => 65];
                @endphp

                @foreach($areas as $area => $percentage)
                <div class="mb-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span>{{ ucfirst($area) }}</span>
                        <span>{{ $percentage }}%</span>
                    </div>
                    <div class="progress" style="height: 10px;">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="dashboard-card">
            <h5>Top-tier Purchase Client</h5>
            <div class="mt-3">
                @if(isset($topClients) && count($topClients) > 0)
                    @foreach($topClients as $index => $client)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $index + 1 }}. {{ $client->name }}</span>
                            <span>₱{{ number_format($client->total_purchase, 2) }}</span>
                        </div>
                    @endforeach
                @else
                    <p>No client data available</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .dashboard-card {
        background-color: #f0f0f0;
        border-radius: 5px;
        padding: 20px;
        height: 200px;
        position: relative;
    }

    .dashboard-card h5 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }

    .calendar-header {
        background-color: #000;
        color: #fff;
        padding: 5px;
        text-align: center;
        margin-bottom: 8px;
    }

    .calendar-table {
        width: 100%;
    }

    .calendar-table td {
        text-align: center;
        padding: 3px;
        font-size: 14px;
    }

    .calendar-table thead td {
        font-weight: bold;
    }

    .annual-stats {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-top: 30px;
    }

    .progress {
        height: 20px;
        border-radius: 5px;
    }

    .progress-bar {
        background-color: #FF8000;
    }
</style>
@endsection

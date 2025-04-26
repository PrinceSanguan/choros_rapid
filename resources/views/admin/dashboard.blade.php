@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="dashboard-title">Admin Dashboard</h1>
        </div>
    </div>

    <div class="row mb-4">
        <!-- First Row -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="dashboard-card h-100">
                <h5>Calendar for schedules</h5>
                <div class="calendar-header">
                    {{ $monthName ?? 'CURRENT MONTH' }}
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
                        @php
                            $firstDay = date('N', strtotime(date('Y-m-01')));
                            $firstDay = $firstDay % 7; // Convert to 0 (Sunday) through 6 (Saturday)
                            $daysInMonth = date('t');
                            $day = 1;
                            $rows = ceil(($daysInMonth + $firstDay) / 7);
                        @endphp

                        @for ($i = 0; $i < $rows; $i++)
                            <tr>
                                @for ($j = 0; $j < 7; $j++)
                                    @if (($i === 0 && $j < $firstDay) || $day > $daysInMonth)
                                        <td></td>
                                    @else
                                        <td class="{{ isset($calendarData[$day]) && count($calendarData[$day]) > 0 ? 'has-events' : '' }}">
                                            {{ $day }}
                                            @if (isset($calendarData[$day]) && count($calendarData[$day]) > 0)
                                                <div class="event-indicator" data-toggle="tooltip" data-html="true"
                                                    title="@foreach($calendarData[$day] as $event){{ $event->title }}<br>@endforeach">
                                                    <span>{{ count($calendarData[$day]) }}</span>
                                                </div>
                                            @endif
                                        </td>
                                        @php $day++; @endphp
                                    @endif
                                @endfor
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="dashboard-card h-100">
                <h5>total annual for week(sale)</h5>
                <div class="annual-stats">
                    ₱{{ number_format($weeklyAnnualSale ?? 0, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Second Row -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="dashboard-card h-100">
                <h5>Accomplishment of project</h5>
                <div class="project-stats">
                    <div class="progress mt-2 mb-3" style="height: 24px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $projectAccomplishment ?? 0 }}%;" aria-valuenow="{{ $projectAccomplishment ?? 0 }}" aria-valuemin="0" aria-valuemax="100">{{ $projectAccomplishment ?? 0 }}%</div>
                    </div>
                    <p class="project-count">{{ $completedProjects ?? 0 }} completed out of {{ $totalProjects ?? 0 }} projects</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="dashboard-card h-100">
                <h5>total annual for month (sale)</h5>
                <div class="annual-stats">
                    ₱{{ number_format($monthlyAnnualSale ?? 0, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Third Row -->
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="dashboard-card h-100">
                <h5>Area of accomplishment</h5>
                <div class="area-stats">
                    @if(isset($areaAccomplishment))
                        @foreach($areaAccomplishment as $area => $percentage)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="area-name">{{ $area }}</span>
                                <span class="area-percentage">{{ $percentage }}%</span>
                            </div>
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="no-data">No area data available</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="dashboard-card h-100">
                <h5>Top-tier Purchase Client</h5>
                <div class="client-stats">
                    @if(isset($topClients) && count($topClients) > 0)
                        @foreach($topClients as $index => $client)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $index + 1 }}. {{ $client->name }}</span>
                                <span>₱{{ number_format($client->total_purchase, 2) }}</span>
                            </div>
                        @endforeach
                    @else
                        <p class="no-data">No client data available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Dashboard title styling */
    .dashboard-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
    }

    /* Card styling */
    .dashboard-card {
        background-color: #f0ebe8;
        border-radius: 5px;
        padding: 20px;
        position: relative;
        height: 100%;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .dashboard-card h5 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
        color: #333;
    }

    /* Calendar styling */
    .calendar-header {
        background-color: #000;
        color: #fff;
        padding: 5px;
        text-align: center;
        margin-bottom: 8px;
        font-weight: bold;
    }

    .calendar-table {
        width: 100%;
        table-layout: fixed;
    }

    .calendar-table td {
        text-align: center;
        padding: 5px 3px;
        font-size: 14px;
        position: relative;
        height: 35px;
    }

    .calendar-table thead td {
        font-weight: bold;
    }

    .calendar-table td.has-events {
        font-weight: bold;
        color: #FF8000;
        position: relative;
    }

    .event-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        background-color: #FF8000;
        color: white;
        border-radius: 50%;
        width: 15px;
        height: 15px;
        font-size: 9px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    /* Financial stats styling */
    .annual-stats {
        font-size: 28px;
        font-weight: bold;
        text-align: right;
        margin-top: 40px;
        color: #333;
    }

    /* Project progress styling */
    .project-stats {
        margin-top: 10px;
    }

    .project-count {
        font-size: 14px;
        margin-top: 5px;
    }

    .progress {
        height: 20px;
        border-radius: 5px;
        background-color: #e9ecef;
    }

    .progress-bar {
        background-color: #FF8000;
    }

    /* Area accomplishment styling */
    .area-stats {
        margin-top: 10px;
    }

    .area-name {
        font-weight: 500;
    }

    .area-percentage {
        font-weight: 500;
    }

    /* Client stats styling */
    .client-stats {
        margin-top: 10px;
    }

    .no-data {
        color: #666;
        font-style: italic;
    }

    /* Responsive adjustments */
    @media (max-width: 767px) {
        .annual-stats {
            font-size: 24px;
            margin-top: 20px;
        }

        .dashboard-card {
            margin-bottom: 20px;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Initialize tooltips for calendar events
    $(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection

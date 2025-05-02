@extends('layouts.app')

@section('title', 'Admin Dashboard')

@php
use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container-fluid px-0">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="dashboard-title">Admin Dashboard</h1>
        </div>
    </div>

    <div class="row mb-4">
        <!-- First Row -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="dashboard-card h-100">
                <h5>Calendar for schedules</h5>
                <div class="calendar-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <button class="btn-calendar-nav prev-month"><i class="fas fa-chevron-left"></i></button>
                        <span>{{ $monthName ?? 'CURRENT MONTH' }}</span>
                        <button class="btn-calendar-nav next-month"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>
                <div class="table-responsive">
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
                                                    <div class="event-indicator" data-day="{{ $day }}">
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
        </div>
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="dashboard-card h-100">
                <h5>Total weekly sales</h5>
                <div class="annual-stats">
                    ₱{{ number_format($weeklyAnnualSale ?? 0, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- Second Row -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="dashboard-card h-100">
                <h5>Project accomplishment</h5>
                <div class="project-stats">
                    <div class="progress mt-2 mb-3" style="height: 24px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $projectAccomplishment ?? 0 }}%;" aria-valuenow="{{ $projectAccomplishment ?? 0 }}" aria-valuemin="0" aria-valuemax="100">{{ $projectAccomplishment ?? 0 }}%</div>
                    </div>
                    <p class="project-count">{{ $completedProjects ?? 0 }} completed out of {{ $totalProjects ?? 0 }} projects</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="dashboard-card h-100">
                <h5>Total monthly sales</h5>
                <div class="annual-stats">
                    ₱{{ number_format($monthlyAnnualSale ?? 0, 2) }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Third Row -->
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="dashboard-card h-100">
                <h5>Area accomplishment</h5>
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
        <div class="col-lg-6 col-md-12 mb-4">
            <div class="dashboard-card h-100">
                <h5>Top-tier Purchase Client</h5>
                <div class="client-stats">
                    @if(isset($topClients) && count($topClients) > 0)
                        @foreach($topClients as $index => $client)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="client-name">{{ $index + 1 }}. {{ $client->name }}</span>
                                <span class="client-amount">₱{{ number_format($client->total_purchase, 2) }}</span>
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

<!-- Calendar Event Modals -->
@if(isset($calendarData))
    @foreach($calendarData as $day => $events)
        @if(count($events) > 0)
            <div class="calendar-event-modal" id="event-modal-{{ $day }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5>Events on {{ $monthName ?? 'Current Month' }} {{ $day }}</h5>
                        <button type="button" class="close-modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        @foreach($events as $event)
                            <div class="event-item">
                                <h6 class="event-title">{{ $event->title }}</h6>
                                <div class="event-detail">
                                    @if($event->project)
                                        <p><strong>Project:</strong> {{ Str::limit($event->project->name, 40) }}</p>
                                    @endif
                                    <p><strong>Time:</strong> {{ date('h:i A', strtotime($event->start_date)) }}</p>
                                    @if($event->description)
                                        <p><strong>Description:</strong> {{ Str::limit($event->description, 100) }}</p>
                                    @endif
                                    @if($event->project && $event->project->location)
                                        <p><strong>Location:</strong> {{ Str::limit($event->project->location, 40) }}</p>
                                    @endif
                                    @if($event->project && $event->project->contractor)
                                        <p><strong>Contractor:</strong> {{ Str::limit($event->project->contractor, 40) }}</p>
                                    @endif
                                    <p><strong>Status:</strong>
                                        <span class="badge {{ $event->status == 'completed' ? 'bg-success' : ($event->status == 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </p>
                                    <div class="mt-2">
                                        <a href="{{ route('schedules.show', $event->id) }}" class="btn btn-sm btn-info">View Details</a>
                                    </div>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endif
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
        text-transform: capitalize;
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

    .btn-calendar-nav {
        background: none;
        border: none;
        color: #fff;
        cursor: pointer;
        padding: 0 8px;
    }

    .btn-calendar-nav:hover {
        color: #76cd26;
    }

    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
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
        color: #76cd26;
        position: relative;
    }

    .event-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        background-color: #76cd26;
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

    /* Calendar Event Modal */
    .calendar-event-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s, visibility 0.3s;
    }

    .calendar-event-modal.active {
        opacity: 1;
        visibility: visible;
        display: flex;
    }

    .modal-content {
        background-color: #fff;
        border-radius: 5px;
        overflow: hidden;
        width: 90%;
        max-width: 450px;
        max-height: 80vh;
        margin: 0 auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .modal-header {
        background-color: #76cd26;
        color: white;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h5 {
        margin: 0;
        font-size: 18px;
        font-weight: 600;
    }

    .close-modal {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        padding: 0;
        line-height: 1;
    }

    .modal-body {
        padding: 20px;
        max-height: calc(80vh - 60px);
        overflow-y: auto;
    }

    .event-item {
        margin-bottom: 15px;
    }

    .event-title {
        color: #333;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .event-detail p {
        margin-bottom: 8px;
        font-size: 14px;
    }

    .event-detail .btn {
        margin-top: 5px;
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
        background-color: #76cd26;
    }

    /* Area accomplishment styling */
    .area-stats {
        margin-top: 10px;
    }

    .area-name {
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 70%;
    }

    .area-percentage {
        font-weight: 500;
    }

    /* Client stats styling */
    .client-stats {
        margin-top: 10px;
    }

    .client-name {
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 70%;
    }

    .client-amount {
        font-weight: 500;
    }

    .no-data {
        color: #666;
        font-style: italic;
    }

    /* Responsive adjustments */
    @media (max-width: 991px) {
        .dashboard-title {
            font-size: 22px;
        }

        .dashboard-card {
            padding: 15px;
        }

        .annual-stats {
            font-size: 26px;
            margin-top: 30px;
        }
    }

    @media (max-width: 767px) {
        .dashboard-title {
            font-size: 20px;
            margin-bottom: 15px;
        }

        .annual-stats {
            font-size: 22px;
            margin-top: 15px;
        }

        .dashboard-card {
            margin-bottom: 15px;
            padding: 15px 12px;
        }

        .dashboard-card h5 {
            font-size: 14px;
            margin-bottom: 10px;
        }

        .calendar-table td {
            padding: 4px 2px;
            font-size: 12px;
            height: 30px;
        }

        .event-indicator {
            width: 12px;
            height: 12px;
            font-size: 8px;
        }

        .modal-content {
            width: 95%;
            max-height: 85vh;
        }

        .modal-body {
            padding: 15px;
        }

        .event-title {
            font-size: 16px;
        }

        .event-detail p {
            font-size: 13px;
        }

        .progress {
            height: 15px;
        }

        .project-count {
            font-size: 13px;
        }
    }

    @media (max-width: 576px) {
        .dashboard-title {
            font-size: 18px;
            text-align: center;
        }

        .dashboard-card {
            padding: 12px 10px;
        }

        .annual-stats {
            font-size: 20px;
            margin-top: 10px;
        }

        .calendar-header {
            font-size: 13px;
        }

        .calendar-table td {
            padding: 3px 1px;
            font-size: 11px;
            height: 25px;
        }

        .event-indicator {
            width: 10px;
            height: 10px;
            font-size: 7px;
            right: 1px;
            bottom: 1px;
        }

        .modal-header h5 {
            font-size: 16px;
        }

        .modal-body {
            padding: 12px;
        }

        .event-title {
            font-size: 15px;
        }

        .event-detail p {
            font-size: 12px;
        }

        .event-detail .btn {
            font-size: 11px;
            padding: 0.25rem 0.5rem;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    // Update real-time clock
    function updateClock() {
        const now = new Date();
        const options = {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: 'numeric',
            minute: 'numeric',
            second: 'numeric',
            hour12: true
        };
        document.getElementById('current-datetime').textContent = now.toLocaleDateString('en-US', options);
    }

    // Update immediately and then every second
    updateClock();
    setInterval(updateClock, 1000);

    // Calendar navigation
    document.addEventListener('DOMContentLoaded', function() {
        const prevMonthBtn = document.querySelector('.prev-month');
        const nextMonthBtn = document.querySelector('.next-month');

        if (prevMonthBtn && nextMonthBtn) {
            prevMonthBtn.addEventListener('click', function() {
                navigateCalendar('prev');
            });

            nextMonthBtn.addEventListener('click', function() {
                navigateCalendar('next');
            });
        }

        function navigateCalendar(direction) {
            const currentUrl = new URL(window.location.href);
            const searchParams = currentUrl.searchParams;

            // Get current month and year from URL or use current date
            let month = parseInt(searchParams.get('month') || (new Date()).getMonth() + 1);
            let year = parseInt(searchParams.get('year') || (new Date()).getFullYear());

            // Calculate new month and year
            if (direction === 'prev') {
                month -= 1;
                if (month < 1) {
                    month = 12;
                    year -= 1;
                }
            } else {
                month += 1;
                if (month > 12) {
                    month = 1;
                    year += 1;
                }
            }

            // Update URL params
            searchParams.set('month', month);
            searchParams.set('year', year);

            // Navigate to new URL
            window.location.href = currentUrl.toString();
        }
    });

    // Modal functionality for calendar events
    document.addEventListener('DOMContentLoaded', function() {
        // Get all event indicators
        const eventIndicators = document.querySelectorAll('.event-indicator');
        const modals = document.querySelectorAll('.calendar-event-modal');
        const closeButtons = document.querySelectorAll('.close-modal');

        // For detecting if we're on mobile
        const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

        // Show modal on click for both mobile and desktop for better consistency
        eventIndicators.forEach(indicator => {
            const day = indicator.getAttribute('data-day');
            const modal = document.getElementById(`event-modal-${day}`);

            if (modal) {
                indicator.addEventListener('click', function(e) {
                    showModal(modal);
                    e.stopPropagation();
                });
            }
        });

        // Function to show modal
        function showModal(modal) {
            // Hide all other modals first
            modals.forEach(m => {
                m.classList.remove('active');
            });

            // Show this modal
            modal.classList.add('active');

            // Prevent body scrolling when modal is open
            document.body.style.overflow = 'hidden';
        }

        // Function to hide modal
        function hideModal(modal) {
            modal.classList.remove('active');
            // Restore body scrolling
            document.body.style.overflow = '';
        }

        // Close modal when clicking the close button
        closeButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                hideModal(this.closest('.calendar-event-modal'));
                e.stopPropagation();
            });
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(e) {
            modals.forEach(modal => {
                if (modal.classList.contains('active')) {
                    const modalContent = modal.querySelector('.modal-content');
                    if (!modalContent.contains(e.target)) {
                        hideModal(modal);
                    }
                }
            });
        });

        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                modals.forEach(modal => {
                    if (modal.classList.contains('active')) {
                        hideModal(modal);
                    }
                });
            }
        });

        // Handle window resize
        window.addEventListener('resize', function() {
            // Adjust modal position if needed
            modals.forEach(modal => {
                if (modal.classList.contains('active')) {
                    const modalContent = modal.querySelector('.modal-content');
                    if (modalContent) {
                        // Ensure modal stays properly centered
                        if (window.innerWidth <= 576) {
                            modalContent.style.maxHeight = '90vh';
                        } else {
                            modalContent.style.maxHeight = '80vh';
                        }
                    }
                }
            });
        });
    });
</script>
@endsection

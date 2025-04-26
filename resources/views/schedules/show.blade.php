@extends('layouts.app')

@section('title', 'Schedule Details')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Schedule Details</span>
                    <div>
                        <a href="{{ route('schedules.edit', $schedule->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="{{ route('schedules.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 30%;">Title:</th>
                            <td>{{ $schedule->title }}</td>
                        </tr>
                        @if($schedule->project)
                        <tr>
                            <th>Project:</th>
                            <td>
                                <a href="{{ route('projects.show', $schedule->project->id) }}">
                                    {{ $schedule->project->name }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Project Status:</th>
                            <td>
                                <span class="badge {{ $schedule->project->status == 'completed' ? 'bg-success' : ($schedule->project->status == 'pending' ? 'bg-warning' : 'bg-info') }}">
                                    {{ ucfirst($schedule->project->status ?? 'N/A') }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Location:</th>
                            <td>{{ $schedule->project->location ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Contractor:</th>
                            <td>{{ $schedule->project->contractor ?? 'N/A' }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Description:</th>
                            <td>{{ $schedule->description ?? 'No description available' }}</td>
                        </tr>
                        <tr>
                            <th>Start Date:</th>
                            <td>{{ $schedule->start_date ? date('Y-m-d H:i', strtotime($schedule->start_date)) : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>End Date:</th>
                            <td>{{ $schedule->end_date ? date('Y-m-d H:i', strtotime($schedule->end_date)) : 'Not specified' }}</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge {{ $schedule->status == 'completed' ? 'bg-success' : ($schedule->status == 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                    {{ ucfirst($schedule->status) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Created By:</th>
                            <td>{{ $schedule->user ? $schedule->user->name : 'Unknown' }}</td>
                        </tr>
                        <tr>
                            <th>Created At:</th>
                            <td>{{ $schedule->created_at ? date('Y-m-d H:i', strtotime($schedule->created_at)) : 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $schedule->updated_at ? date('Y-m-d H:i', strtotime($schedule->updated_at)) : 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

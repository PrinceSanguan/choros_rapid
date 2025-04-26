@extends('layouts.app')

@section('title', 'Schedules')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-8">
            <h2>Schedules</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('schedules.create') }}" class="btn btn-primary">Create New Schedule</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Project</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                            <tr>
                                <td>{{ $schedule->title }}</td>
                                <td>{{ $schedule->project ? $schedule->project->name : 'N/A' }}</td>
                                <td>{{ $schedule->start_date ? date('Y-m-d H:i', strtotime($schedule->start_date)) : 'N/A' }}</td>
                                <td>{{ $schedule->end_date ? date('Y-m-d H:i', strtotime($schedule->end_date)) : 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $schedule->status == 'completed' ? 'bg-success' : ($schedule->status == 'cancelled' ? 'bg-danger' : 'bg-warning') }}">
                                        {{ ucfirst($schedule->status) }}
                                    </span>
                                </td>
                                <td>{{ $schedule->user ? $schedule->user->name : 'Unknown' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('schedules.show', $schedule->id) }}" class="btn btn-sm btn-info">View</a>
                                        <a href="{{ route('schedules.edit', $schedule->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this schedule?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No schedules found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $schedules->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

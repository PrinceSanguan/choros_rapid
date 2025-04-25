@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5>Projects</h5>
                <a href="{{ route('projects.create') }}" class="btn btn-primary">Add Project</a>
            </div>

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Project Name</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Contractor</th>
                            <th>Project Size</th>
                            <th>Start Date</th>
                            <th>Project Manager</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr>
                                <td>{{ $project->id }}</td>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->date ? $project->date->format('M d, Y') : 'N/A' }}</td>
                                <td>{{ $project->location }}</td>
                                <td>{{ $project->contractor }}</td>
                                <td>{{ $project->size }}</td>
                                <td>{{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }}</td>
                                <td>{{ $project->project_manager ?: 'N/A' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary btn-sm">Edit</a>
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No projects found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

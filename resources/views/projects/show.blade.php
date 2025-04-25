@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Project Details</h5>
                        <div>
                            <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">Edit</a>
                            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to Projects</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4>{{ $project->name }}</h4>
                            <span class="badge bg-{{ $project->status === 'completed' ? 'success' : ($project->status === 'ongoing' ? 'primary' : 'warning') }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Location:</strong>
                                <p>{{ $project->location }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Contractor:</strong>
                                <p>{{ $project->customer->name ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Project Size:</strong>
                                <p>{{ $project->size }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Budget:</strong>
                                <p>₱{{ number_format($project->budget, 2) }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Project Manager:</strong>
                                <p>{{ $project->manager->name ?? 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Start Date:</strong>
                                <p>{{ $project->start_date ? $project->start_date->format('F d, Y') : 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>End Date:</strong>
                                <p>{{ $project->end_date ? $project->end_date->format('F d, Y') : 'N/A' }}</p>
                            </div>
                            <div class="mb-3">
                                <strong>Created At:</strong>
                                <p>{{ $project->created_at->format('F d, Y H:i A') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <strong>Description:</strong>
                            <p>{{ $project->description ?: 'No description available.' }}</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Project</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

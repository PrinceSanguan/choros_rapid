@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <h2>Project Manager Dashboard</h2>
        <div>
            <a href="{{ route('projects.registration') }}" class="action-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                Register New Project
            </a>
        </div>
    </div>

    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-value">{{ $projectsCount }}</div>
            <div class="stat-label">Total Projects</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $pendingProjects }}</div>
            <div class="stat-label">Pending</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $ongoingProjects }}</div>
            <div class="stat-label">Ongoing</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $completedProjects }}</div>
            <div class="stat-label">Completed</div>
        </div>
    </div>

    <!-- Project Registration Form -->
    <div class="card shadow mt-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="card-title">Quick Project Registration</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('projects.store') }}" method="POST" id="projectForm">
                @csrf
                <div class="project-grid">
                    <div class="grid-row header">
                        <div class="grid-cell">Project Name</div>
                        <div class="grid-cell">Date</div>
                    </div>
                    <div class="grid-row">
                        <div class="grid-cell input-cell">
                            <input type="text" name="name" class="form-control" placeholder="Enter project name" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid-cell input-cell">
                            <input type="date" name="start_date" class="form-control" required>
                            @error('start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid-row header">
                        <div class="grid-cell">Location</div>
                        <div class="grid-cell">Contractor</div>
                    </div>
                    <div class="grid-row">
                        <div class="grid-cell input-cell">
                            <input type="text" name="location" class="form-control" placeholder="Enter location" required>
                            @error('location')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid-cell input-cell">
                            <input type="text" name="contractor" class="form-control" placeholder="Enter contractor name" required>
                            @error('contractor')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid-row header">
                        <div class="grid-cell">Project Size</div>
                        <div class="grid-cell">Budget</div>
                    </div>
                    <div class="grid-row">
                        <div class="grid-cell input-cell">
                            <input type="text" name="project_size" class="form-control" placeholder="Enter project size" required>
                            @error('project_size')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid-cell input-cell">
                            <input type="number" name="budget" class="form-control" placeholder="Enter project budget" required min="0" step="0.01">
                            @error('budget')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4>Notes</h4>
                    <textarea name="description" class="form-control notes-field" rows="3"></textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <input type="hidden" name="manager_id" value="{{ auth()->id() }}">
                <input type="hidden" name="status" value="pending">

                <div class="form-actions">
                    <button type="reset" class="btn-cancel">Clear Form</button>
                    <button type="submit" class="btn-save">Save Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Recent Projects -->
    <div class="card shadow mt-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="card-title">Recent Projects</span>
                </div>
                <div>
                    <a href="{{ route('projects.index') }}" class="view-all">View All</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Project Name</th>
                            <th>Location</th>
                            <th>Start Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->location }}</td>
                            <td>{{ $project->start_date }}</td>
                            <td>
                                <span class="status-badge status-{{ $project->status }}">{{ ucfirst($project->status) }}</span>
                            </td>
                            <td class="action-links">
                                <a href="{{ route('projects.show', $project->id) }}" class="btn-view" title="View Project">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn-edit" title="Edit Project">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No projects found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .container-fluid {
        padding: 0 25px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 10px 0;
    }

    .content-header h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        color: #333;
    }

    .action-button {
        background-color: #FF8000;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
    }

    .action-button:hover {
        background-color: #e67300;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        color: white;
        text-decoration: none;
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 20px;
    }

    .stat-card {
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #FF8000;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 14px;
        color: #666;
    }

    .card.shadow {
        box-shadow: 0 4px 15px rgba(0,0,0,0.08) !important;
        border: none;
        border-radius: 8px;
        overflow: hidden;
    }

    .card-header {
        background-color: #f8f9fa;
        font-weight: 600;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }

    .card-title {
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .view-all {
        font-size: 14px;
        color: #FF8000;
        text-decoration: none;
    }

    .view-all:hover {
        text-decoration: underline;
    }

    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .align-items-center {
        align-items: center;
    }

    .card-body {
        padding: 20px;
    }

    .project-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
        margin-bottom: 20px;
    }

    .grid-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .grid-row.header {
        margin-top: 15px;
        margin-bottom: 5px;
    }

    .grid-cell {
        padding: 5px 0;
        font-weight: 500;
    }

    .input-cell {
        padding: 0;
    }

    .form-control {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: all 0.3s;
        background-color: #fff8f0;
    }

    .form-control:focus {
        outline: none;
        border-color: #FF8000;
        box-shadow: 0 0 0 2px rgba(255, 128, 0, 0.1);
    }

    .form-section {
        margin-top: 20px;
    }

    .form-section h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }

    .notes-field {
        width: 100%;
        min-height: 80px;
        background-color: #fff8f0;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-cancel {
        padding: 8px 20px;
        border: 1px solid #ddd;
        background-color: white;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-cancel:hover {
        background-color: #f5f5f5;
    }

    .btn-save {
        padding: 8px 20px;
        border: none;
        background-color: #FF8000;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-save:hover {
        background-color: #e67300;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .mt-4 {
        margin-top: 25px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background-color: #f1f1f1;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e3e6f0;
    }

    .data-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #e3e6f0;
    }

    .data-table tr:hover {
        background-color: #f9f9fa;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 500;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
    }

    .status-ongoing {
        background-color: #cce5ff;
        color: #004085;
    }

    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .action-links {
        display: flex;
        gap: 10px;
    }

    .btn-view, .btn-edit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .btn-view {
        background-color: #e8f5e9;
        color: #2e7d32;
    }

    .btn-view:hover {
        background-color: #2e7d32;
        color: white;
    }

    .btn-edit {
        background-color: #e3f2fd;
        color: #0d47a1;
    }

    .btn-edit:hover {
        background-color: #0d47a1;
        color: white;
    }

    /* Responsive styles */
    @media (max-width: 992px) {
        .stats-cards {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .content-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .grid-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding: 0 15px;
        }

        .stats-cards {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

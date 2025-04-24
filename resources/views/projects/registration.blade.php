@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <h2>Project Registration</h2>
        <div>
            <a href="javascript:void(0);" onclick="document.getElementById('projectForm').reset();" class="action-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>
                Clear Form
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
            </svg>
            {{ session('success') }}
            <button type="button" class="close-btn" onclick="this.parentElement.style.display='none';">×</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-triangle-fill" viewBox="0 0 16 16">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
            </svg>
            {{ session('error') }}
            <button type="button" class="close-btn" onclick="this.parentElement.style.display='none';">×</button>
        </div>
    @endif

    <div class="card shadow">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="card-title">Register New Project</span>
                </div>
                <div class="search-container">
                    <input type="text" id="projectSearch" class="search-input" placeholder="Search projects..." onkeyup="searchTable()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="search-icon" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
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
                        <div class="grid-cell"></div>
                    </div>
                    <div class="grid-row">
                        <div class="grid-cell input-cell">
                            <input type="text" name="location" class="form-control" placeholder="Enter location" required>
                            @error('location')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid-cell"></div>
                    </div>

                    <div class="grid-row header">
                        <div class="grid-cell">Contractor</div>
                        <div class="grid-cell"></div>
                    </div>
                    <div class="grid-row">
                        <div class="grid-cell input-cell">
                            <input type="text" name="contractor" class="form-control" placeholder="Enter contractor name" required>
                            @error('contractor')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid-cell"></div>
                    </div>

                    <div class="grid-row header">
                        <div class="grid-cell">Project Size</div>
                        <div class="grid-cell"></div>
                    </div>
                    <div class="grid-row">
                        <div class="grid-cell input-cell">
                            <input type="text" name="project_size" class="form-control" placeholder="Enter project size" required>
                            @error('project_size')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid-cell"></div>
                    </div>

                    <div class="grid-row header">
                        <div class="grid-cell">Budget</div>
                        <div class="grid-cell"></div>
                    </div>
                    <div class="grid-row">
                        <div class="grid-cell input-cell">
                            <input type="number" name="budget" class="form-control" placeholder="Enter project budget" required min="0" step="0.01">
                            @error('budget')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="grid-cell"></div>
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

                <div class="form-section mt-4">
                    <h4>Work Plan</h4>
                    <div class="work-plan-area">
                        <div class="timeline">
                            <div class="timeline-labels">
                                <div>Week 1</div>
                                <div>Week 2</div>
                                <div>Week 3</div>
                                <div>Week 4</div>
                            </div>
                            <div class="timeline-chart">
                                <!-- Work plan timeline visualization would go here -->
                                <div class="chart-area">
                                    <svg width="100%" height="100%" viewBox="0 0 800 150">
                                        <line x1="0" y1="75" x2="800" y2="75" stroke="#ddd" stroke-width="2"/>
                                        <!-- Example task bars -->
                                        <rect x="50" y="30" width="150" height="30" fill="#FF8000" opacity="0.7" rx="5"/>
                                        <rect x="250" y="30" width="200" height="30" fill="#FF8000" opacity="0.7" rx="5"/>
                                        <rect x="500" y="30" width="250" height="30" fill="#FF8000" opacity="0.7" rx="5"/>

                                        <rect x="100" y="80" width="300" height="30" fill="#4c6ef5" opacity="0.7" rx="5"/>
                                        <rect x="450" y="80" width="200" height="30" fill="#4c6ef5" opacity="0.7" rx="5"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('projects.index') }}" class="btn-cancel">Cancel</a>
                    <button type="submit" class="btn-save">Save Project</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Projects List -->
    <div class="card shadow mt-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="card-title">My Projects</span>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table" id="projectsTable">
                    <thead>
                        <tr>
                            <th>Project Name</th>
                            <th>Location</th>
                            <th>Start Date</th>
                            <th>Budget</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                        <tr>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->location }}</td>
                            <td>{{ $project->start_date->format('M d, Y') }}</td>
                            <td>${{ number_format($project->budget, 2) }}</td>
                            <td>
                                <span class="status-badge status-{{ $project->status }}">
                                    {{ ucfirst($project->status) }}
                                </span>
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
                            <td colspan="6" class="text-center empty-table">
                                <div class="no-data">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                        <path d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                    </svg>
                                    <p>No projects found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                {{ $projects->links() }}
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

    .card.shadow {
        box-shadow: 0 4px 15px rgba(0,0,0,0.08) !important;
        border: none;
        border-radius: 8px;
        overflow: hidden;
        margin-bottom: 30px;
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

    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }

    .align-items-center {
        align-items: center;
    }

    .search-container {
        position: relative;
    }

    .search-input {
        padding: 8px 12px 8px 35px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        width: 250px;
        transition: all 0.3s;
    }

    .search-input:focus {
        outline: none;
        border-color: #FF8000;
        box-shadow: 0 0 0 2px rgba(255, 128, 0, 0.2);
        width: 300px;
    }

    .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #aaa;
    }

    .card-body {
        padding: 20px;
    }

    .project-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 10px;
        margin-bottom: 30px;
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

    .work-plan-area {
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 15px;
        margin-top: 10px;
        background-color: #fff;
    }

    .timeline {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .timeline-labels {
        display: flex;
        justify-content: space-between;
        padding: 0 20px;
    }

    .timeline-chart {
        height: 150px;
        border-radius: 4px;
        overflow: hidden;
    }

    .chart-area {
        height: 100%;
        width: 100%;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #eee;
    }

    .btn-cancel {
        padding: 10px 20px;
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
        padding: 10px 20px;
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

    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-dismissible {
        position: relative;
        padding-right: 35px;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .close-btn {
        position: absolute;
        top: 0;
        right: 0;
        padding: 15px;
        color: inherit;
        opacity: 0.7;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
    }

    .close-btn:hover {
        opacity: 1;
    }

    .mt-4 {
        margin-top: 25px;
    }

    /* Table styles */
    .table-responsive {
        overflow-x: auto;
        min-height: 300px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }

    .data-table th {
        background-color: #f8f9fa;
        padding: 12px 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #e3e6f0;
    }

    .data-table td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #e3e6f0;
        color: #444;
    }

    .data-table tr:hover {
        background-color: #f5f8ff;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
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
        background-color: #e3f2fd;
        color: #0d47a1;
    }

    .btn-view:hover {
        background-color: #0d47a1;
        color: white;
    }

    .btn-edit {
        background-color: #fff3e0;
        color: #e65100;
    }

    .btn-edit:hover {
        background-color: #e65100;
        color: white;
    }

    .empty-table {
        height: 300px;
    }

    .no-data {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #999;
        padding: 50px 0;
    }

    .no-data svg {
        margin-bottom: 10px;
        opacity: 0.5;
    }

    .no-data p {
        font-size: 16px;
    }

    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    /* Responsive styles */
    @media (max-width: 992px) {
        .search-input {
            width: 200px;
        }

        .search-input:focus {
            width: 220px;
        }
    }

    @media (max-width: 768px) {
        .content-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .card-header .d-flex {
            flex-direction: column;
            gap: 15px;
        }

        .search-container {
            width: 100%;
        }

        .search-input, .search-input:focus {
            width: 100%;
        }

        .grid-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding: 0 15px;
        }
    }
</style>

<script>
    // Search functionality
    function searchTable() {
        const input = document.getElementById('projectSearch');
        const filter = input.value.toUpperCase();
        const table = document.getElementById('projectsTable');
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            let found = false;
            const cells = rows[i].getElementsByTagName('td');

            if (cells.length === 0) continue;

            for (let j = 0; j < cells.length - 1; j++) {
                const cell = cells[j];
                if (cell) {
                    const textValue = cell.textContent || cell.innerText;
                    if (textValue.toUpperCase().indexOf(filter) > -1) {
                        found = true;
                        break;
                    }
                }
            }

            rows[i].style.display = found ? '' : 'none';
        }
    }
</script>
@endsection

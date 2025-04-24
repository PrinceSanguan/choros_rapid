@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <h2>Project Management</h2>
        <div>
            @if(auth()->check() && auth()->user()->hasRole('admin'))
                <a href="{{ route('projects.create') }}" class="action-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Add New Project
                </a>
            @elseif(auth()->check() && auth()->user()->hasRole('project-manager'))
                <a href="{{ route('projects.registration') }}" class="action-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                    </svg>
                    Register New Project
                </a>
            @endif
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
                    <span class="card-title">Project List</span>
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
            <div class="table-responsive">
                <table class="data-table" id="projectsTable">
                    <thead>
                        <tr>
                            <th>
                                <div class="th-content">
                                    Project Name
                                    <span class="sort-icon" onclick="sortTable(0)">↕</span>
                                </div>
                            </th>
                            <th>
                                <div class="th-content">
                                    Location
                                    <span class="sort-icon" onclick="sortTable(1)">↕</span>
                                </div>
                            </th>
                            <th>
                                <div class="th-content">
                                    Contractor
                                    <span class="sort-icon" onclick="sortTable(2)">↕</span>
                                </div>
                            </th>
                            <th>
                                <div class="th-content">
                                    Start Date
                                    <span class="sort-icon" onclick="sortTable(3)">↕</span>
                                </div>
                            </th>
                            <th>
                                <div class="th-content">
                                    Status
                                    <span class="sort-icon" onclick="sortTable(4)">↕</span>
                                </div>
                            </th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->location }}</td>
                            <td>{{ $project->contractor }}</td>
                            <td>
                                <span class="timestamp" title="{{ $project->start_date }}">
                                    {{ $project->start_date }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $project->status }}">{{ ucfirst($project->status) }}</span>
                            </td>
                            <td class="action-links text-center">
                                <a href="{{ route('projects.show', $project->id) }}" class="btn-view" title="View Project">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                    </svg>
                                </a>

                                @if(auth()->check() && (auth()->user()->hasRole('admin') || (auth()->user()->hasRole('project-manager') && $project->manager_id == auth()->id())))
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn-edit" title="Edit Project">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                </a>
                                @endif

                                @if(auth()->check() && auth()->user()->hasRole('admin'))
                                <a href="#" class="btn-delete" title="Delete Project" onclick="event.preventDefault(); confirmDelete('{{ $project->id }}', '{{ $project->name }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </a>
                                <form id="delete-form-{{ $project->id }}" action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach

                        @if($projects->isEmpty())
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
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="pagination-container">
                {{ $projects->links() }}
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirm Delete</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the project <span id="deleteProjectName"></span>?</p>
                <p class="warning-text">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeModal()">Cancel</button>
                <button class="btn-confirm-delete" onclick="submitDelete()">Delete</button>
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
        padding: 0;
    }

    .table-responsive {
        overflow-x: auto;
        min-height: 300px;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
        table-layout: fixed;
    }

    .data-table th {
        background-color: #f1f1f1;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #333;
        border: none;
        border-bottom: 2px solid #e3e6f0;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .th-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .sort-icon {
        cursor: pointer;
        opacity: 0.5;
        transition: opacity 0.2s;
    }

    .sort-icon:hover {
        opacity: 1;
    }

    .data-table td {
        padding: 15px;
        vertical-align: middle;
        border: none;
        border-bottom: 1px solid #e3e6f0;
        color: #444;
        word-break: break-word;
    }

    .data-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .data-table tr:hover {
        background-color: #f1f1f1;
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

    .timestamp {
        color: #666;
        font-size: 14px;
    }

    .action-links {
        white-space: nowrap;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .btn-view, .btn-edit, .btn-delete {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 35px;
        height: 35px;
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
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-edit {
        background-color: #e3f2fd;
        color: #0d47a1;
    }

    .btn-edit:hover {
        background-color: #0d47a1;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-delete {
        background-color: #ffebee;
        color: #c62828;
    }

    .btn-delete:hover {
        background-color: #c62828;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .text-center {
        text-align: center;
    }

    .pagination-container {
        padding: 15px;
        display: flex;
        justify-content: center;
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

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: white;
        border-radius: 8px;
        width: 400px;
        max-width: 90%;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        animation: modalFadeIn 0.3s;
    }

    @keyframes modalFadeIn {
        from {opacity: 0; transform: translateY(-20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid #eee;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 18px;
        color: #333;
    }

    .close {
        color: #aaa;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover {
        color: #333;
    }

    .modal-body {
        padding: 20px;
    }

    .warning-text {
        color: #c62828;
        font-size: 14px;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        padding: 15px 20px;
        border-top: 1px solid #eee;
    }

    .btn-cancel {
        padding: 8px 15px;
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

    .btn-confirm-delete {
        padding: 8px 15px;
        border: none;
        background-color: #c62828;
        color: white;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-confirm-delete:hover {
        background-color: #b71c1c;
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

        .data-table th,
        .data-table td {
            padding: 10px;
        }

        .btn-view, .btn-edit, .btn-delete {
            width: 30px;
            height: 30px;
        }
    }

    @media (max-width: 576px) {
        .container-fluid {
            padding: 0 15px;
        }

        .action-links {
            flex-direction: column;
            gap: 8px;
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

            if (cells.length === 0) continue; // Skip header row

            for (let j = 0; j < cells.length - 1; j++) { // Skip the action column
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

    // Sorting functionality
    let sortDirection = 1; // 1 for ascending, -1 for descending
    let lastColumn = -1;

    function sortTable(columnIndex) {
        const table = document.getElementById('projectsTable');
        const tbody = table.querySelector('tbody');
        const rows = Array.from(tbody.querySelectorAll('tr'));

        // Reverse direction if same column is clicked again
        if (lastColumn === columnIndex) {
            sortDirection *= -1;
        } else {
            sortDirection = 1;
            lastColumn = columnIndex;
        }

        // Sort the rows
        rows.sort((rowA, rowB) => {
            // Skip if it's the "No projects found" row
            if (rowA.cells.length === 1 || rowB.cells.length === 1) return 0;

            const cellA = rowA.cells[columnIndex].textContent.trim();
            const cellB = rowB.cells[columnIndex].textContent.trim();

            if (!isNaN(Date.parse(cellA)) && !isNaN(Date.parse(cellB))) {
                // Sort by date
                return (new Date(cellA) - new Date(cellB)) * sortDirection;
            } else {
                // Sort by text
                return cellA.localeCompare(cellB) * sortDirection;
            }
        });

        // Reattach rows in sorted order
        rows.forEach(row => tbody.appendChild(row));
    }

    // Delete confirmation modal
    let projectIdToDelete = null;

    function confirmDelete(projectId, projectName) {
        projectIdToDelete = projectId;
        document.getElementById('deleteProjectName').textContent = projectName;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    function submitDelete() {
        if (projectIdToDelete) {
            document.getElementById(`delete-form-${projectIdToDelete}`).submit();
        }
        closeModal();
    }

    // Close modal if user clicks outside of it
    window.onclick = function(event) {
        const modal = document.getElementById('deleteModal');
        if (event.target === modal) {
            closeModal();
        }
    };
</script>
@endsection

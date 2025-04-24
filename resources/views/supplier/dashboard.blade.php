@extends('supplier.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="content-header">
        <h2>Supplier Dashboard</h2>
    </div>

    <div class="stats-cards">
        <div class="stat-card">
            <div class="stat-value">{{ $projectsCount }}</div>
            <div class="stat-label">Total Projects</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $weeklyIncome }}</div>
            <div class="stat-label">Weekly Income</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $monthlyIncome }}</div>
            <div class="stat-label">Monthly Income</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $lowStockItems }}</div>
            <div class="stat-label">Low Stock Items</div>
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
                        @forelse($recentProjects as $project)
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

    <!-- Supplier Inventory -->
    <div class="card shadow mt-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="card-title">Inventory Management</span>
                </div>
                <div>
                    <a href="{{ route('inventory.index') }}" class="view-all">View All</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>In Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventory->take(5) as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->category }}</td>
                            <td>{{ $item->in_stock }}</td>
                            <td>
                                @if($item->in_stock < 10)
                                <span class="status-badge status-low">Low Stock</span>
                                @else
                                <span class="status-badge status-ok">In Stock</span>
                                @endif
                            </td>
                            <td class="action-links">
                                <a href="{{ route('inventory.show', $item->id) }}" class="btn-view" title="View Item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                        <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('inventory.edit', $item->id) }}" class="btn-edit" title="Edit Item">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No inventory items found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

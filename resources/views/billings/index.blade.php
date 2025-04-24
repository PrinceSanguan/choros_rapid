@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Billing Transactions</h1>
        <a href="{{ route('billings.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Create New Billing
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Billing Transactions List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="billings-table" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Invoice #</th>
                            <th>Date</th>
                            <th>Due Date</th>
                            <th>Project</th>
                            <th>Customer</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($billings as $billing)
                            <tr>
                                <td>{{ $billing->id }}</td>
                                <td>{{ $billing->invoice_number }}</td>
                                <td>{{ $billing->created_at->format('M d, Y') }}</td>
                                <td>{{ $billing->due_date->format('M d, Y') }}</td>
                                <td>{{ $billing->project->name ?? 'N/A' }}</td>
                                <td>{{ $billing->customer->name ?? 'N/A' }}</td>
                                <td>{{ number_format($billing->total_amount, 2) }}</td>
                                <td>
                                    @if($billing->status == 'paid')
                                        <span class="badge badge-success">Paid</span>
                                    @elseif($billing->status == 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($billing->status == 'overdue')
                                        <span class="badge badge-danger">Overdue</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($billing->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('billings.show', $billing->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('billings.edit', $billing->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('billings.destroy', $billing->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this billing transaction?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No billing transactions found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end">
                {{ $billings->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#billings-table').DataTable({
            "order": [[0, "desc"]],
            "pageLength": 25,
            "searching": true,
            "responsive": true,
            "dom": '<"top"f>rt<"bottom"lip><"clear">',
        });
    });
</script>
@endpush
@endsection

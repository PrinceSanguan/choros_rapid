@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Billing Transaction Details</h6>
                    <div>
                        <a href="{{ route('billings.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Back to Billings
                        </a>
                        <a href="{{ route('billings.edit', $billing->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button class="btn btn-sm btn-success" onclick="window.print()">
                            <i class="fas fa-print"></i> Print
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="mb-3">From:</h6>
                            <div>
                                <strong>{{ config('app.name') }}</strong>
                            </div>
                            <div>123 Company Street</div>
                            <div>City, State ZIP</div>
                            <div>Phone: (123) 456-7890</div>
                            <div>Email: info@company.com</div>
                        </div>

                        <div class="col-sm-6">
                            <h6 class="mb-3">To:</h6>
                            <div>
                                <strong>{{ $billing->customer->name ?? 'N/A' }}</strong>
                            </div>
                            <div>{{ $billing->customer->address ?? 'N/A' }}</div>
                            <div>{{ $billing->customer->city ?? '' }}, {{ $billing->customer->state ?? '' }} {{ $billing->customer->zip ?? '' }}</div>
                            <div>Phone: {{ $billing->customer->phone ?? 'N/A' }}</div>
                            <div>Email: {{ $billing->customer->email ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-6">
                            <h6 class="mb-3">Billing Details:</h6>
                            <div><strong>Invoice Number:</strong> {{ $billing->invoice_number }}</div>
                            <div><strong>Date:</strong> {{ $billing->created_at->format('M d, Y') }}</div>
                            <div><strong>Due Date:</strong> {{ $billing->due_date->format('M d, Y') }}</div>
                            <div>
                                <strong>Status:</strong>
                                @if($billing->status == 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @elseif($billing->status == 'pending')
                                    <span class="badge badge-warning">Pending</span>
                                @elseif($billing->status == 'overdue')
                                    <span class="badge badge-danger">Overdue</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($billing->status) }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <h6 class="mb-3">Project Details:</h6>
                            <div><strong>Project:</strong> {{ $billing->project->name ?? 'N/A' }}</div>
                            <div><strong>Project Code:</strong> {{ $billing->project->code ?? 'N/A' }}</div>
                            <div><strong>Project Manager:</strong> {{ $billing->project->manager->name ?? 'N/A' }}</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Item Description</th>
                                            <th>Quantity</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($billing->items as $index => $item)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->price, 2) }}</td>
                                                <td>{{ number_format($item->quantity * $item->price, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
                                            <td>{{ number_format($billing->total_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Tax:</strong></td>
                                            <td>{{ number_format(0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Total:</strong></td>
                                            <td><strong>{{ number_format($billing->total_amount, 2) }}</strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    @if($billing->notes)
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0">Notes</h6>
                                    </div>
                                    <div class="card-body">
                                        {{ $billing->notes }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Payment Information</h6>
                                </div>
                                <div class="card-body">
                                    <p>Please make payment to the following account:</p>
                                    <p>Bank: Bank Name<br>
                                    Account Name: Company Name<br>
                                    Account Number: 1234567890<br>
                                    Routing Number: 987654321</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-muted text-center">
                    Thank you for your business!
                </div>
            </div>
        </div>
    </div>
</div>

<style media="print">
    @page {
        size: auto;
        margin: 10mm;
    }
    body {
        margin: 0;
        padding: 0;
    }
    .no-print, .no-print * {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    .card-header, .card-footer {
        background-color: white !important;
    }
</style>
@endsection

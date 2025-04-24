@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Create New Billing Transaction</h6>
                    <a href="{{ route('billings.index') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-arrow-left"></i> Back to Billings
                    </a>
                </div>
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('billings.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="invoice_number">Invoice Number</label>
                                    <input type="text" class="form-control @error('invoice_number') is-invalid @enderror"
                                           id="invoice_number" name="invoice_number" value="{{ old('invoice_number') }}" required>
                                    @error('invoice_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_date">Due Date</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror"
                                           id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_id">Project</label>
                                    <select class="form-control @error('project_id') is-invalid @enderror"
                                            id="project_id" name="project_id" required>
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="customer_id">Customer</label>
                                    <select class="form-control @error('customer_id') is-invalid @enderror"
                                            id="customer_id" name="customer_id" required>
                                        <option value="">Select Customer</option>
                                        @foreach($customers as $customer)
                                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                     id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="card mb-4">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <h6 class="m-0 font-weight-bold text-primary">Billing Items</h6>
                                <button type="button" class="btn btn-sm btn-success" id="add-item">
                                    <i class="fas fa-plus"></i> Add Item
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="items-container">
                                    <div class="item-row row mb-3">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="items[0][description]"
                                                   placeholder="Item Description" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control quantity-input" name="items[0][quantity]"
                                                   placeholder="Quantity" min="1" value="1" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="number" class="form-control price-input" name="items[0][price]"
                                                   placeholder="Unit Price" min="0" step="0.01" required>
                                        </div>
                                        <div class="col-md-2">
                                            <span class="form-control item-total bg-light">0.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 text-right">
                                        <strong>Total Amount:</strong>
                                    </div>
                                    <div class="col-md-2">
                                        <span id="billing-total" class="form-control bg-light font-weight-bold">0.00</span>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">Create Billing</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        let itemIndex = 0;

        // Add new item row
        $('#add-item').click(function() {
            itemIndex++;
            const newRow = `
                <div class="item-row row mb-3">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="items[${itemIndex}][description]"
                               placeholder="Item Description" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control quantity-input" name="items[${itemIndex}][quantity]"
                               placeholder="Quantity" min="1" value="1" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" class="form-control price-input" name="items[${itemIndex}][price]"
                               placeholder="Unit Price" min="0" step="0.01" required>
                    </div>
                    <div class="col-md-2 d-flex">
                        <span class="form-control item-total bg-light">0.00</span>
                        <button type="button" class="btn btn-sm btn-danger ml-2 remove-item">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            `;
            $('#items-container').append(newRow);
            updateTotals();
        });

        // Remove item row
        $(document).on('click', '.remove-item', function() {
            $(this).closest('.item-row').remove();
            updateTotals();
        });

        // Update item totals when quantity or price changes
        $(document).on('input', '.quantity-input, .price-input', function() {
            updateTotals();
        });

        // Calculate totals for each item and billing total
        function updateTotals() {
            let billingTotal = 0;

            $('.item-row').each(function() {
                const quantity = parseFloat($(this).find('.quantity-input').val()) || 0;
                const price = parseFloat($(this).find('.price-input').val()) || 0;
                const total = quantity * price;

                $(this).find('.item-total').text(total.toFixed(2));
                billingTotal += total;
            });

            $('#billing-total').text(billingTotal.toFixed(2));
        }
    });
</script>
@endpush
@endsection

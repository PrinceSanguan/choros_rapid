@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-plus-circle me-2"></i>
                        <h5 class="mb-0">Add New Product</h5>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Product Information -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Product Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="product_title" class="form-label">Product Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('product_title') is-invalid @enderror"
                                                id="product_title" name="product_title" value="{{ old('product_title') }}" required>
                                            @error('product_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                                <option value="" selected disabled>Select Category</option>
                                                <option value="Electronics" {{ old('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                                <option value="Clothing" {{ old('category') == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                                                <option value="Food" {{ old('category') == 'Food' ? 'selected' : '' }}>Food</option>
                                                <option value="Furniture" {{ old('category') == 'Furniture' ? 'selected' : '' }}>Furniture</option>
                                                <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control @error('description') is-invalid @enderror"
                                                id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                            @error('description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Product Photo</label>
                                            <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                                id="photo" name="photo" accept="image/*">
                                            <small class="form-text text-muted">Upload a clear image of the product (Max: 10MB)</small>
                                            @error('photo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Inventory & Price Details -->
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Inventory & Price Details</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                                id="quantity" name="quantity" value="{{ old('quantity') }}" min="0" required>
                                            @error('quantity')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="in_stock" class="form-label">In Stock <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control @error('in_stock') is-invalid @enderror"
                                                id="in_stock" name="in_stock" value="{{ old('in_stock') }}" min="0" required>
                                            @error('in_stock')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="buying_price" class="form-label">Buying Price ($) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('buying_price') is-invalid @enderror"
                                                id="buying_price" name="buying_price" value="{{ old('buying_price') }}" min="0" required>
                                            @error('buying_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="selling_price" class="form-label">Selling Price ($) <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" class="form-control @error('selling_price') is-invalid @enderror"
                                                id="selling_price" name="selling_price" value="{{ old('selling_price') }}" min="0" required>
                                            @error('selling_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0">Supplier Information</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="supplier_id" class="form-label">Supplier</label>
                                            <select class="form-select @error('supplier_id') is-invalid @enderror" id="supplier_id" name="supplier_id">
                                                <option value="">None</option>
                                                @foreach($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('supplier_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-arrow-left me-1"></i> Back to Inventory
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save me-1"></i> Save Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

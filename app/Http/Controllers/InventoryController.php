<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class InventoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the inventory items.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventory = Inventory::latest()->paginate(10);
        return view('inventory.index', compact('inventory'));
    }

    /**
     * Show the form for creating a new inventory item.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('name')->get();
        return view('inventory.create', compact('suppliers'));
    }

    /**
     * Store a newly created inventory item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'in_stock' => 'required|integer|min:0',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('inventory', 'public');
            $validated['photo'] = $photoPath;
        }

        // Create inventory item
        Inventory::create($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Product added successfully');
    }

    /**
     * Display the specified inventory item.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        return view('inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified inventory item.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        $suppliers = Supplier::orderBy('name')->get();
        return view('inventory.edit', compact('inventory', 'suppliers'));
    }

    /**
     * Update the specified inventory item in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        $validated = $request->validate([
            'product_title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'in_stock' => 'required|integer|min:0',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($inventory->photo) {
                Storage::disk('public')->delete($inventory->photo);
            }

            $photoPath = $request->file('photo')->store('inventory', 'public');
            $validated['photo'] = $photoPath;
        }

        // Update inventory item
        $inventory->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified inventory item from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        // Delete photo if exists
        if ($inventory->photo) {
            Storage::disk('public')->delete($inventory->photo);
        }

        $inventory->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Product deleted successfully');
    }
}

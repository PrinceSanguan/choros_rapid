<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    /**
     * Display a listing of the inventory items.
     */
    public function index()
    {
        $inventory = Inventory::with(['category', 'addedBy'])
            ->latest()
            ->paginate(10);

        return view('inventory.index', compact('inventory'));
    }

    /**
     * Show the form for creating a new inventory item.
     */
    public function create()
    {
        $categories = ProductCategory::all();
        return view('inventory.create', compact('categories'));
    }

    /**
     * Store a newly created inventory item in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_title' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'in_stock' => 'required|integer|min:0',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();
        $data['added_by'] = Auth::id();

        // Handle file upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('public/inventory');
            $data['photo'] = Storage::url($path);
        }

        Inventory::create($data);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item created successfully.');
    }

    /**
     * Display the specified inventory item.
     */
    public function show(Inventory $inventory)
    {
        $inventory->load(['category', 'addedBy']);
        return view('inventory.show', compact('inventory'));
    }

    /**
     * Show the form for editing the specified inventory item.
     */
    public function edit(Inventory $inventory)
    {
        $categories = ProductCategory::all();
        return view('inventory.edit', compact('inventory', 'categories'));
    }

    /**
     * Update the specified inventory item in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'product_title' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'in_stock' => 'required|integer|min:0',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        // Handle file upload
        if ($request->hasFile('photo')) {
            // Delete old image if exists
            if ($inventory->photo) {
                $oldPath = str_replace('/storage', 'public', $inventory->photo);
                Storage::delete($oldPath);
            }

            $path = $request->file('photo')->store('public/inventory');
            $data['photo'] = Storage::url($path);
        }

        $inventory->update($data);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item updated successfully.');
    }

    /**
     * Remove the specified inventory item from storage.
     */
    public function destroy(Inventory $inventory)
    {
        // Delete the image if exists
        if ($inventory->photo) {
            $path = str_replace('/storage', 'public', $inventory->photo);
            Storage::delete($path);
        }

        $inventory->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item deleted successfully.');
    }
}

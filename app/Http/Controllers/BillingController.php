<?php

namespace App\Http\Controllers;

use App\Models\BillingTransaction;
use App\Models\BillingItem;
use App\Models\Project;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillingController extends Controller
{
    /**
     * Display a listing of the billing transactions.
     */
    public function index()
    {
        $billings = BillingTransaction::with(['project', 'customer', 'createdBy'])
            ->latest()
            ->paginate(10);

        return view('billings.index', compact('billings'));
    }

    /**
     * Show the form for creating a new billing transaction.
     */
    public function create()
    {
        $projects = Project::where('status', 'ongoing')->get();
        $customers = Customer::where('is_active', true)->get();

        return view('billings.create', compact('projects', 'customers'));
    }

    /**
     * Store a newly created billing transaction in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|string|unique:billing_transactions',
            'due_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Calculate total amount
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            // Create the billing transaction
            $billing = BillingTransaction::create([
                'invoice_number' => $request->invoice_number,
                'project_id' => $request->project_id,
                'customer_id' => $request->customer_id,
                'amount' => $totalAmount,
                'status' => 'pending',
                'due_date' => $request->due_date,
                'notes' => $request->notes,
                'created_by' => Auth::id(),
            ]);

            // Create billing items
            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['price'];

                BillingItem::create([
                    'billing_transaction_id' => $billing->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $itemTotal,
                ]);
            }

            DB::commit();

            return redirect()->route('billings.index')
                ->with('success', 'Billing transaction created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified billing transaction.
     */
    public function show(BillingTransaction $billing)
    {
        $billing->load(['project', 'customer', 'createdBy', 'items']);
        return view('billings.show', compact('billing'));
    }

    /**
     * Show the form for editing the specified billing transaction.
     */
    public function edit(BillingTransaction $billing)
    {
        $projects = Project::all();
        $customers = Customer::where('is_active', true)->get();
        $billing->load('items');

        return view('billings.edit', compact('billing', 'projects', 'customers'));
    }

    /**
     * Update the specified billing transaction in storage.
     */
    public function update(Request $request, BillingTransaction $billing)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|string|unique:billing_transactions,invoice_number,' . $billing->id,
            'due_date' => 'required|date',
            'status' => 'required|in:pending,paid,cancelled',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:billing_items,id',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            // Calculate total amount
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            // Update the billing transaction
            $billing->update([
                'invoice_number' => $request->invoice_number,
                'project_id' => $request->project_id,
                'customer_id' => $request->customer_id,
                'amount' => $totalAmount,
                'status' => $request->status,
                'due_date' => $request->due_date,
                'notes' => $request->notes,
            ]);

            // Delete existing items and create new ones
            $billing->items()->delete();

            // Create billing items
            foreach ($request->items as $item) {
                $itemTotal = $item['quantity'] * $item['price'];

                BillingItem::create([
                    'billing_transaction_id' => $billing->id,
                    'description' => $item['description'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $itemTotal,
                ]);
            }

            DB::commit();

            return redirect()->route('billings.index')
                ->with('success', 'Billing transaction updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'An error occurred: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified billing transaction from storage.
     */
    public function destroy(BillingTransaction $billing)
    {
        // Delete all associated items first (should happen through cascade, but being explicit)
        $billing->items()->delete();
        $billing->delete();

        return redirect()->route('billings.index')
            ->with('success', 'Billing transaction deleted successfully.');
    }
}

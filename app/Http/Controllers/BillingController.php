<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BillingTransaction;
use App\Models\Customer;
use App\Models\Project;

class BillingController extends Controller
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
     * Display a listing of the billings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billings = BillingTransaction::with(['customer', 'project'])
            ->latest()
            ->paginate(10);

        return view('billings.index', compact('billings'));
    }

    /**
     * Show the form for creating a new billing.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        $payment_methods = ['Cash', 'Credit Card', 'Bank Transfer', 'Check', 'PayPal', 'Other'];

        return view('billings.create', compact('customers', 'projects', 'payment_methods'));
    }

    /**
     * Store a newly created billing in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'nullable|string|max:255|unique:billing_transactions,invoice_number',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,paid,overdue,cancelled',
            'payment_method' => 'required|string|max:255',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        // Generate invoice number if not provided
        if (empty($validated['invoice_number'])) {
            $validated['invoice_number'] = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
        }

        BillingTransaction::create($validated);

        return redirect()->route('billings.index')
            ->with('success', 'Billing created successfully.');
    }

    /**
     * Display the specified billing.
     *
     * @param  \App\Models\BillingTransaction  $billing
     * @return \Illuminate\Http\Response
     */
    public function show(BillingTransaction $billing)
    {
        $billing->load(['customer', 'project']);

        return view('billings.show', compact('billing'));
    }

    /**
     * Show the form for editing the specified billing.
     *
     * @param  \App\Models\BillingTransaction  $billing
     * @return \Illuminate\Http\Response
     */
    public function edit(BillingTransaction $billing)
    {
        $customers = Customer::orderBy('name')->get();
        $projects = Project::orderBy('name')->get();
        $payment_methods = ['Cash', 'Credit Card', 'Bank Transfer', 'Check', 'PayPal', 'Other'];

        return view('billings.edit', compact('billing', 'customers', 'projects', 'payment_methods'));
    }

    /**
     * Update the specified billing in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BillingTransaction  $billing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BillingTransaction $billing)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'nullable|string|max:255|unique:billing_transactions,invoice_number,' . $billing->id,
            'amount' => 'required|numeric|min:0',
            'status' => 'required|string|in:pending,paid,overdue,cancelled',
            'payment_method' => 'required|string|max:255',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $billing->update($validated);

        return redirect()->route('billings.index')
            ->with('success', 'Billing updated successfully.');
    }

    /**
     * Remove the specified billing from storage.
     *
     * @param  \App\Models\BillingTransaction  $billing
     * @return \Illuminate\Http\Response
     */
    public function destroy(BillingTransaction $billing)
    {
        $billing->delete();

        return redirect()->route('billings.index')
            ->with('success', 'Billing deleted successfully.');
    }
}

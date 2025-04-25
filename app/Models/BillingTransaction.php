<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'customer_id',
        'invoice_number',
        'amount',
        'status',
        'payment_method',
        'description',
        'due_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
    ];

    /**
     * Get the project that owns the billing transaction.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get the customer that owns the billing transaction.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date',
        'location',
        'contractor',
        'size',
        'start_date',
        'project_manager',
        'description',
        'status',
        'budget',
        'customer_id',
        'manager_id',
    ];

    protected $casts = [
        'date' => 'date',
        'start_date' => 'date',
        'budget' => 'decimal:2',
    ];

    /**
     * Get the customer that owns the project.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the manager that oversees the project.
     */
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    /**
     * Get the billing transactions for the project.
     */
    public function billingTransactions()
    {
        return $this->hasMany(BillingTransaction::class);
    }

    /**
     * Get the schedules for the project.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get inventory items associated with the project.
     */
    public function inventory()
    {
        return $this->belongsToMany(Inventory::class, 'project_inventory')
            ->withPivot('quantity', 'unit_price')
            ->withTimestamps();
    }
}

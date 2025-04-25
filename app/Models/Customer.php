<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'contact_person',
        'company_name',
    ];

    /**
     * Get the projects for the customer.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the billing transactions for the customer.
     */
    public function billingTransactions()
    {
        return $this->hasMany(BillingTransaction::class);
    }
}

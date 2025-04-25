<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'company_name',
        'user_id',
    ];

    /**
     * Get the inventory items supplied by this supplier.
     */
    public function inventoryItems()
    {
        return $this->hasMany(Inventory::class);
    }

    /**
     * Get the user associated with this supplier.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

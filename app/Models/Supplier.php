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
    ];

    /**
     * Get the inventory items provided by this supplier.
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}

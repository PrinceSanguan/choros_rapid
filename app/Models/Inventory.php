<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'supplier_id',
        'category',
        'in_stock',
        'unit',
        'unit_price',
        'reorder_level',
    ];

    protected $casts = [
        'unit_price' => 'decimal:2',
    ];

    /**
     * Get the supplier that provides this inventory item.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

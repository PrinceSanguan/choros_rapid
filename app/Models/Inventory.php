<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_title',
        'category',
        'description',
        'photo',
        'quantity',
        'in_stock',
        'buying_price',
        'selling_price',
        'supplier_id',
    ];

    protected $casts = [
        'buying_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'product_added' => 'datetime',
    ];

    /**
     * Get the supplier associated with the inventory item.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the formatted buying price.
     */
    public function getFormattedBuyingPriceAttribute()
    {
        return '₦' . number_format($this->buying_price, 2);
    }

    /**
     * Get the formatted selling price.
     */
    public function getFormattedSellingPriceAttribute()
    {
        return '₦' . number_format($this->selling_price, 2);
    }

    /**
     * Get the profit margin.
     */
    public function getProfitMarginAttribute()
    {
        if ($this->buying_price > 0) {
            $profit = $this->selling_price - $this->buying_price;
            return number_format(($profit / $this->buying_price) * 100, 2) . '%';
        }
        return 'N/A';
    }
}

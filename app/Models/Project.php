<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'contractor',
        'project_size',
        'start_date',
        'end_date',
        'budget',
        'description',
        'status',
        'manager_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'budget' => 'decimal:2',
    ];

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function billingTransactions()
    {
        return $this->hasMany(BillingTransaction::class);
    }
}

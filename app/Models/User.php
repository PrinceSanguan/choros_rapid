<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'position',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The roles that belong to the user
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if user has the specified position
     */
    public function hasPosition($position)
    {
        return $this->position === $position;
    }

    /**
     * Check if user has the specified role
     * This is an alias of hasPosition for consistency with role middleware
     */
    public function hasRole($role)
    {
        // Handle multiple roles check (e.g., 'admin|project-manager')
        if (strpos($role, '|') !== false) {
            $roles = explode('|', $role);
            foreach ($roles as $r) {
                if (strtolower($this->position) === strtolower($r)) {
                    return true;
                }
            }
            return false;
        }

        return strtolower($this->position) === strtolower($role);
    }

    /**
     * Get the projects managed by the user
     */
    public function managedProjects()
    {
        return $this->hasMany(Project::class, 'manager_id');
    }

    /**
     * Get all billing transactions created by the user
     */
    public function billingTransactions()
    {
        return $this->hasMany(BillingTransaction::class, 'created_by');
    }

    /**
     * Get all inventory items added by the user
     */
    public function inventoryItems()
    {
        return $this->hasMany(Inventory::class, 'added_by');
    }
}

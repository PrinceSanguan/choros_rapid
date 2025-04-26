<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        'last_login_at' => 'datetime',
    ];

    /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->position === 'admin';
    }

    /**
     * Determine if the user is a project manager.
     *
     * @return bool
     */
    public function isProjectManager()
    {
        return $this->position === 'project-manager';
    }

    /**
     * Determine if the user is an accountant.
     *
     * @return bool
     */
    public function isAccountant()
    {
        return $this->position === 'accountant';
    }

    /**
     * Determine if the user is inventory staff.
     *
     * @return bool
     */
    public function isInventoryStaff()
    {
        return $this->position === 'inventory-staff';
    }

    /**
     * Determine if the user is a supplier.
     *
     * @return bool
     */
    public function isSupplier()
    {
        return $this->position === 'supplier';
    }

    /**
     * Get the projects managed by this user.
     */
    public function managedProjects()
    {
        return $this->hasMany(Project::class, 'manager_id');
    }

    /**
     * Get the schedules created by this user.
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'role_id',
        'section',
        'can_create',
        'can_read',
        'can_update',
        'can_delete',
    ];

    /**
     * Relationship: Permission belongs to a Role
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
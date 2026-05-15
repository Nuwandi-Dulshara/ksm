<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreelanceCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status',
    ];

    public function freelancers()
    {
        return $this->hasMany(Freelancer::class, 'category', 'slug');
    }
}

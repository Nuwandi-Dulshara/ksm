<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Income;

class Donator extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'contact_number',
        'email',
        'address',
    ];

    /**
     * A Donator can have many Incomes
     */
    public function incomes()
    {
        return $this->hasMany(Income::class);
    }
}
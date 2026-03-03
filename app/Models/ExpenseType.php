<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ExpenseCategory;

class ExpenseType extends Model
{
    protected $fillable = ['expense_type'];

    // Relationship: One Expense Type has many Categories
    public function categories()
    {
        return $this->hasMany(ExpenseCategory::class);
    }
}
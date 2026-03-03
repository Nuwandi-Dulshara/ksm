<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    protected $fillable = [
        'expense_type_id',
        'category_name'
    ];

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }
}
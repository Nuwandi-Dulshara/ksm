<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    protected $fillable = [
        'expense_type_id',
        'expense_category_id',
        'amount',
        'date',
        'beneficiary',
        'description',
        'receipt',
        'status',
        'admin_note'
    ];

    public function expenseType()
    {
        return $this->belongsTo(ExpenseType::class);
    }

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
}
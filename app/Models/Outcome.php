<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Outcome extends Model
{
    protected $fillable = [
        'expense_type_id',
        'expense_category_id',
        'created_by',
        'amount',
        'date',
        'beneficiary',
        'description',
        'receipt',
        'status',
        'decided_by',
        'decided_at',
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function decisionBy()
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovedSalarySheet extends Model
{
    protected $fillable = [
        'salary_month',
        'salary_rows',
        'basic_salary_total',
        'bonus_total',
        'deduction_total',
        'net_payable_total',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'salary_month' => 'date',
        'salary_rows' => 'array',
        'approved_at' => 'datetime',
        'basic_salary_total' => 'decimal:2',
        'bonus_total' => 'decimal:2',
        'deduction_total' => 'decimal:2',
        'net_payable_total' => 'decimal:2',
    ];

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}

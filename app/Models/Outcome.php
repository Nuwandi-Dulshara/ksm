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
        'invoice_number',
        'receipt',
        'status',
        'decided_by',
        'decided_at',
        'admin_note'
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-generate invoice number on creation
        static::creating(function ($model) {
            if (!$model->invoice_number) {
                $model->invoice_number = self::generateInvoiceNumber();
            }
        });
    }

    /**
     * Generate a unique invoice number
     * Format: INV-YYYYMMDD-XXXXX (e.g., INV-20260521-00001)
     */
    public static function generateInvoiceNumber()
    {
        $date = now()->format('Ymd');
        $count = self::whereDate('created_at', now())->count();
        $sequence = str_pad($count + 1, 5, '0', STR_PAD_LEFT);
        
        return "INV-{$date}-{$sequence}";
    }

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

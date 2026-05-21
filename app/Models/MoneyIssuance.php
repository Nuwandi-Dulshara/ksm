<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MoneyIssuance extends Model
{
    protected $fillable = [
        'issued_to_id',
        'recipient_type',
        'amount',
        'reason',
        'description',
        'notes',
        'issued_date',
        'status',
        'created_by',
        'approved_by',
        'approved_at',
        'admin_note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'issued_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function issuedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_to_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeByDateRange($query, $startDate = null, $endDate = null)
    {
        if ($startDate) {
            $query->whereDate('issued_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('issued_date', '<=', $endDate);
        }
        
        return $query;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'donator_id',
        'invoice_number',
        'amount',
        'received_date',
        'description',
        'invoice_file',
    ];

    public function donator()
    {
        return $this->belongsTo(Donator::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancer extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'category',
        'service_skill',
        'phone_number',
        'email',
        'billing_rate',
        'rate_type',
        'status',
        'payment_details',
        'portfolio_url',
        'contract_path',
    ];

    public function categoryDefinition()
    {
        return $this->belongsTo(FreelanceCategory::class, 'category', 'slug');
    }
}

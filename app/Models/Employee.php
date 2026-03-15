<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'job_title',
        'gender',
        'date_of_birth',
        'phone_number',
        'email',
        'base_monthly_salary',
        'join_date',
        'employment_status',
        'payment_method',
        'bank_details',
        'document_path',
    ];
}

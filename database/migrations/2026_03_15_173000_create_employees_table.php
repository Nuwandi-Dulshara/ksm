<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('job_title')->nullable();
            $table->string('gender', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->string('email')->nullable()->unique();
            $table->decimal('base_monthly_salary', 12, 2);
            $table->date('join_date');
            $table->string('employment_status', 50)->default('active');
            $table->string('payment_method', 20)->default('cash');
            $table->text('bank_details')->nullable();
            $table->string('document_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

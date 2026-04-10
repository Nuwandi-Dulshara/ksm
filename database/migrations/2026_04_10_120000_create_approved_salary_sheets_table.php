<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approved_salary_sheets', function (Blueprint $table) {
            $table->id();
            $table->date('salary_month')->unique();
            $table->json('salary_rows');
            $table->decimal('basic_salary_total', 12, 2)->default(0);
            $table->decimal('bonus_total', 12, 2)->default(0);
            $table->decimal('deduction_total', 12, 2)->default(0);
            $table->decimal('net_payable_total', 12, 2)->default(0);
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approved_salary_sheets');
    }
};

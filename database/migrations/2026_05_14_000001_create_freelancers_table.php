<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('freelancers', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('category');
            $table->string('service_skill')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->string('email')->nullable()->unique();
            $table->decimal('billing_rate', 12, 2)->default(0);
            $table->string('rate_type')->default('project');
            $table->string('status')->default('active');
            $table->text('payment_details')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('contract_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freelancers');
    }
};

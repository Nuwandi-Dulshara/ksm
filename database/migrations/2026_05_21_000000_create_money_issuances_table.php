<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('money_issuances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('issued_to_id'); // User ID of recipient
            $table->string('recipient_type')->default('employee'); // employee, freelancer, other
            $table->decimal('amount', 12, 2);
            $table->string('reason')->nullable(); // Why money was given
            $table->text('description')->nullable(); // Additional details
            $table->text('notes')->nullable(); // Additional notes
            $table->date('issued_date');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->text('admin_note')->nullable();
            $table->timestamps();
            
            // Foreign keys
            $table->foreign('issued_to_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('money_issuances');
    }
};

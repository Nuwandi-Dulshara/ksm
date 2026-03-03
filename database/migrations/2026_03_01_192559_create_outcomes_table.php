<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('outcomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('expense_category_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('amount', 12, 2);
            $table->date('date');
            $table->string('beneficiary')->nullable();
            $table->text('description')->nullable();
            $table->string('receipt')->nullable();
            $table->string('status')->default('pending');
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outcomes');
    }
};

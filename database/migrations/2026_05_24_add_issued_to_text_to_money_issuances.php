<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('money_issuances', function (Blueprint $table) {
            // Add string column to store recipient name/text
            $table->string('issued_to')->nullable()->after('issued_to_id');
            
            // Make issued_to_id nullable since not all recipients are system users
            $table->unsignedBigInteger('issued_to_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('money_issuances', function (Blueprint $table) {
            $table->dropColumn('issued_to');
            $table->unsignedBigInteger('issued_to_id')->nullable(false)->change();
        });
    }
};

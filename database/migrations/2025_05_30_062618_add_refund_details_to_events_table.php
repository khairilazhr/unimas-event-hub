<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('supporting_docs')->nullable()->after('qr_code'); // Adds after qr_code
            $table->string('refund_type')->nullable()->after('supporting_docs'); // Adds after supporting_docs
            $table->string('refund_policy')->nullable()->after('refund_type'); // Adds after refund_type
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};

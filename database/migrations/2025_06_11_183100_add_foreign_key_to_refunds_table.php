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
        Schema::table('refunds', function (Blueprint $table) {
            // Add the event_registration_id column
            $table->unsignedBigInteger('event_registration_id')->after('ticket_id');

            // Add foreign key constraints
            $table->foreign('event_registration_id')->references('id')->on('event_registrations')->onDelete('cascade');

            // Ensure one refund request per registration
            $table->unique(['event_registration_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('refunds', function (Blueprint $table) {
            // Drop foreign key and column if rolling back
            $table->dropForeign(['event_registration_id']);
            $table->dropColumn('event_registration_id');
        });
    }
};

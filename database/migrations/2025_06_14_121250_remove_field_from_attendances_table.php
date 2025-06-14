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
        Schema::table('attendances', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['event_id']);
            $table->dropForeign(['ticket_id']);
            $table->dropForeign(['user_id']);

            // Then drop the columns
            $table->dropColumn(['event_id', 'ticket_id', 'user_id']);
        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Recreate columns
            $table->foreignId('event_id')->constrained('events');
            $table->foreignId('ticket_id')->constrained('tickets');
            $table->foreignId('user_id')->constrained('users');
        });
    }
};

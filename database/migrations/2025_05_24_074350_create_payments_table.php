<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up()
{
    Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('event_reg_id');
        $table->unsignedBigInteger('user_id');
        $table->string('ref_no')->nullable();
        $table->string('receipt')->nullable();
        $table->timestamps();

        // Foreign keys
        $table->foreign('event_reg_id')
              ->references('id')
              ->on('event_registrations')
              ->onDelete('cascade');
              
        $table->foreign('user_id')
              ->references('id')
              ->on('users')
              ->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

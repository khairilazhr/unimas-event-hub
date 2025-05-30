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
        Schema::create('refunds', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('ticket_id')->constrained('tickets')->onDelete('cascade'); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('refund_reason')->nullable(); 
            $table->decimal('refund_amount', 8, 2); 
            $table->string('status')->default('pending'); 
            $table->text('notes')->nullable(); 
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refunds');
    }
};


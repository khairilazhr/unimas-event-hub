<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->text('payment_details')->change();
        });
    }

    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('payment_details', 1000)->change();
        });
    }
};

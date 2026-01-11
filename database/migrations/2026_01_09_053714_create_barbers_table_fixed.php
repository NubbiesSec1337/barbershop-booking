<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barbers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
             $table->string('phone')->nullable(); 
            $table->text('bio')->nullable();
            $table->tinyInteger('max_slots_per_time')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barbers');
    }
};

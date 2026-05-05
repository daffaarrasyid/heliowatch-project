<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('system_logs', function (Blueprint $table) {
        $table->id();
        $table->timestamp('log_time'); 
        $table->string('time');       
        $table->string('type'); 
        $table->string('severity'); 
        $table->string('condition'); 
        $table->string('action_type'); 
        $table->string('action');      
        $table->string('scenario'); 
        $table->string('status'); 
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('system_logs');
    }
};

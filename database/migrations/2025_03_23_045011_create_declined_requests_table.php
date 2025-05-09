<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('declined_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_id')->constrained()->onDelete('cascade');
            $table->foreignId('priest_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });        
    }

    public function down()
    {
        Schema::dropIfExists('declined_requests');
    }
};

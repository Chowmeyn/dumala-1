<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Schema::create('declined_requests', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
        //     $table->foreignId('referred_priest_id')->nullable()->constrained('priests')->onDelete('set null');
        //     $table->text('reason')->nullable();
        //     $table->timestamps();
        // });
    }

    public function down()
    {
        // Schema::dropIfExists('declined_requests');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResponseProgressTable extends Migration
{
    public function up()
    {
        Schema::create('response_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('response_id')->constrained('responses')->onDelete('cascade');
            $table->json('histories');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('response_progress');
    }
}

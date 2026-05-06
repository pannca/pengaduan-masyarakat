<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('description');
            $table->enum('type', ['KEJAHATAN', 'PEMBANGUNAN', 'SOSIAL']);
            $table->string('province', 255);
            $table->string('regency', 255);
            $table->string('subdistrict', 255);
            $table->string('village', 255);
            $table->json('voting')->nullable();
            $table->integer('viewers')->default(0); // Default nilai views = 0
            $table->string('image')->nullable()->default('/images/default-image.jpg');
            $table->boolean('statement');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
}

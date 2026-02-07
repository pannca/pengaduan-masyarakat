<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffProvincesTable extends Migration
{
    public function up()
    {
        Schema::create('staff_provinces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('province');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('staff_provinces');
    }
}

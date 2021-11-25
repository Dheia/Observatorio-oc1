<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateQuizDevicesTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_quiz_devices', function ($table) {
            $table->increments('id');
            $table->integer('quiz_id')->unsigned()->references('id')->on('tresfera_taketsystem_quizzes')->onDelete('cascade');
            $table->integer('device_id')->unsigned()->references('id')->on('tresfera_taketsystem_devices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_quiz_devices');
    }
}

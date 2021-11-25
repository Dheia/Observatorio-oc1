<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSlidesTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_slides', function ($table) {
            $table->increments('id');
            $table->integer('quiz_id')->unsigned()->references('id')->on('tresfera_taketsystem_quizzes')->onDelete('cascade');
            $table->integer('type_id')->unsigned()->references('id')->on('tresfera_taketsystem_slide_types')->onDelete('cascade');
            $table->string('page');
            $table->string('name');
            $table->text('content')->nullable();
            $table->text('view')->nullable();
            $table->text('syntax_data')->nullable();
            $table->text('syntax_fields')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_slides');
    }
}

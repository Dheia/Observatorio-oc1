<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_answers', function ($table) {
            $table->increments('id');
            $table->integer('result_id')->unsigned()->references('id')->on('tresfera_taketsystem_results')->onDelete('cascade');
            $table->integer('slide_id')->unsigned()->references('id')->on('tresfera_taketsystem_slides')->onDelete('cascade');
            $table->integer('question_number')->unsigned();
            $table->string('question_title');
            $table->string('question_type');
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_answers');
    }
}

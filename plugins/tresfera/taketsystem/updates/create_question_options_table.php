<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateQuestionOptionsTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_question_options', function ($table) {
            $table->increments('id');
            $table->integer('question_id')->nullable()->unsigned()->references('id')->on('tresfera_taketsystem_questions')->onDelete('cascade');
            $table->string('label');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_question_options');
    }
}

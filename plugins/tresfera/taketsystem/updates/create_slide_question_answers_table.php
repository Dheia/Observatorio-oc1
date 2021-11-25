<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSlideQuestionAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_slide_question_answers', function ($table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->integer('type')->unique();
            $table->integer('field_id')->unique();
            $table->integer('answer_id')->unique();
            $table->integer('slidequestion_id')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_slide_questions');
    }
}

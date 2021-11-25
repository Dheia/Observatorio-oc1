<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateQuestionsAnswersTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_questions_answers', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('question_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_questions_answers');
    }
}

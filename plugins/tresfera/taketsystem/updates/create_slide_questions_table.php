<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSlideQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_slide_questions', function ($table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->string('field_id')->unique();
            $table->integer('slide_id')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_slide_questions');
    }
}

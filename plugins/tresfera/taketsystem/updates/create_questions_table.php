<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_questions', function ($table) {
            $table->increments('id');
            $table->string('title');
            $table->integer('sector_id');
            $table->integer('section_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_questions');
    }
}

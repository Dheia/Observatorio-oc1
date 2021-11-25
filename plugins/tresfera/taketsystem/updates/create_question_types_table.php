<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateQuestionTypesTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_question_types', function ($table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_question_types');
    }
}

<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateQuizTypesTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_quiz_types', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_quiz_types');
    }
}

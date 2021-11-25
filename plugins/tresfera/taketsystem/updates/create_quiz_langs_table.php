<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateQuizLangsTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_quiz_langs', function ($table) {
            $table->increments('id');
            $table->string('code');
            $table->integer('quiz_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_quiz_types');
    }
}

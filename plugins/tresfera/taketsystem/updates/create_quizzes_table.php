<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateQuizzesTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_quizzes', function ($table) {
            $table->increments('id');
            $table->integer('type_id')->nullable()->unsigned()->references('id')->on('tresfera_taketsystem_quiz_tipes')->onDelete('cascade');
            $table->boolean('is_template')->default(0);
            $table->integer('client_id')->nullable()->unsigned()->references('id')->on('tresfera_taketsystem_clients')->onDelete('cascade');
            $table->integer('user_id')->nullable()->unsigned()->references('id')->on('tresfera_user_users')->onDelete('set null');
            $table->integer('template_id')->nullable()->unsigned()->references('id')->on('tresfera_user_uquizzes')->onDelete('set null');
            $table->string('title');
            $table->string('template_name')->nullable();
            $table->string('template_description')->nullable();
            $table->timestamp('date_start');
            $table->timestamp('date_end')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_quizzes');
    }
}

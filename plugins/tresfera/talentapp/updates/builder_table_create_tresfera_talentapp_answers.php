<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentappAnswers extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talentapp_answers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('result_id')->unsigned();
            $table->integer('slide_id')->unsigned();
            $table->integer('question_number')->unsigned();
            $table->string('question_title');
            $table->string('question_type');
            $table->string('value')->nullable();
            $table->string('value_type');
            $table->string('answer_type');
            $table->string('lang');
            $table->string('question');
            $table->string('question_dimension');
            $table->string('question_competencia');
            $table->string('question_categoria');
            $table->string('no_analizable');
            $table->integer('question_id')->unsigned();
            $table->integer('duplicated')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_talentapp_answers');
    }
}

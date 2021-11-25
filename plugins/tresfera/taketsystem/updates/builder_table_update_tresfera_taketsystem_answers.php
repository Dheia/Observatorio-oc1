<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemAnswers extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_answers', function($table)
        {
            $table->string('value_type');
            $table->string('answer_type');
            $table->string('question');
            $table->string('lang');
            $table->string('question_dimension');
            $table->string('question_competencia');
            $table->string('question_categoria');
            $table->string('no_analizable');
            $table->string('question_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_answers', function($table)
        {
            $table->dropColumn('value_type');
            $table->dropColumn('answer_type');
            $table->dropColumn('question');
            $table->dropColumn('lang');
            $table->dropColumn('question_dimension');
            $table->dropColumn('question_competencia');
            $table->dropColumn('question_categoria');
            $table->dropColumn('no_analizable');
            $table->dropColumn('question_id');
        });
    }
}

<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemQuizzes6 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->string('sex');
            $table->string('age');
            $table->string('email');
            $table->string('free');
            $table->string('cp');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->dropColumn('sex');
            $table->dropColumn('age');
            $table->dropColumn('email');
            $table->dropColumn('free');
            $table->dropColumn('cp');
        });
    }
}

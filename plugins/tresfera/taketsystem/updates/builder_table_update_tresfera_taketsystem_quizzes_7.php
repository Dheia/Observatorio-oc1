<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemQuizzes7 extends Migration
{
    public function up()
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
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->string('sex', 191);
            $table->string('age', 191);
            $table->string('email', 191);
            $table->string('free', 191);
            $table->string('cp', 191);
        });
    }
}

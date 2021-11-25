<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemQuizzes2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->string('desc', 200);
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_quizzes', function($table)
        {
            $table->dropColumn('desc');
        });
    }
}

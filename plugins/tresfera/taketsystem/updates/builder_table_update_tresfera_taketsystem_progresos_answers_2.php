<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemProgresosAnswers2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_progresos_answers', function($table)
        {
            $table->integer('peso');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_progresos_answers', function($table)
        {
            $table->dropColumn('peso');
        });
    }
}

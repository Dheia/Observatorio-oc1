<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemProgresosAnswers5 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_progresos_answers', function($table)
        {
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_progresos_answers', function($table)
        {
            $table->dropColumn('user_id');
        });
    }
}

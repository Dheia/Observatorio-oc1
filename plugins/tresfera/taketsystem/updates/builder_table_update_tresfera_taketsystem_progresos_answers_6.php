<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemProgresosAnswers6 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_progresos_answers', function($table)
        {
            $table->integer('user_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_progresos_answers', function($table)
        {
            $table->integer('user_id')->nullable(false)->change();
        });
    }
}

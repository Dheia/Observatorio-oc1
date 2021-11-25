<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemProgresosAnswers4 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_progresos_answers', function($table)
        {
            $table->smallInteger('bonus')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_progresos_answers', function($table)
        {
            $table->smallInteger('bonus')->default(null)->change();
        });
    }
}

<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemProgresosAnswers extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_progresos_answers', function($table)
        {
            $table->renameColumn('ponts', 'points');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_progresos_answers', function($table)
        {
            $table->renameColumn('points', 'ponts');
        });
    }
}

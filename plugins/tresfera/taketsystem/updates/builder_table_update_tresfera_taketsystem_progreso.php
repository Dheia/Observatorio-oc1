<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemProgreso extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_progreso', function($table)
        {
            $table->string('start_at');
            $table->string('stop_at');
            $table->integer('time');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_progreso', function($table)
        {
            $table->dropColumn('start_at');
            $table->dropColumn('stop_at');
            $table->dropColumn('time');
        });
    }
}

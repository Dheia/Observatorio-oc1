<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemProgreso2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_progreso', function($table)
        {
            $table->renameColumn('last_pag', 'pag');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_progreso', function($table)
        {
            $table->renameColumn('pag', 'last_pag');
        });
    }
}

<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemResults10 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_results', function($table)
        {
            $table->renameColumn('rol2', 'rol_ok');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_results', function($table)
        {
            $table->renameColumn('rol_ok', 'rol2');
        });
    }
}

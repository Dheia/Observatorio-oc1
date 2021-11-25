<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupEquipo2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_equipo', function($table)
        {
            $table->text('notas');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_equipo', function($table)
        {
            $table->dropColumn('notas');
        });
    }
}

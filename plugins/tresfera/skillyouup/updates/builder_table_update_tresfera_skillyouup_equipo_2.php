<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupEquipo2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_equipo', function($table)
        {
            $table->text('players');
            $table->dropColumn('jefe');
            $table->dropColumn('companero');
            $table->dropColumn('colaborador');
            $table->dropColumn('otro');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_equipo', function($table)
        {
            $table->dropColumn('players');
            $table->text('jefe');
            $table->text('companero');
            $table->text('colaborador');
            $table->text('otro');
        });
    }
}

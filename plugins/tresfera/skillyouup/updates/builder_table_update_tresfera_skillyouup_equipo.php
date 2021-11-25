<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupEquipo extends Migration
{
    public function up()
    {
        Schema::rename('tresfera_skillyouup_evaluacion', 'tresfera_skillyouup_equipo');
    }
    
    public function down()
    {
        Schema::rename('tresfera_skillyouup_equipo', 'tresfera_skillyouup_evaluacion');
    }
}

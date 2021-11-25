<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupEquipo extends Migration
{
    public function up()
    {
        Schema::rename('tresfera_buildyouup_evaluacion', 'tresfera_buildyouup_equipo');
    }
    
    public function down()
    {
        Schema::rename('tresfera_buildyouup_equipo', 'tresfera_buildyouup_evaluacion');
    }
}
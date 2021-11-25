<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaOrganizacionesPersonaPuesto extends Migration
{
    public function up()
    {
        Schema::rename('tresfera_organizaciones_', 'tresfera_organizaciones_persona_puesto');
    }
    
    public function down()
    {
        Schema::rename('tresfera_organizaciones_persona_puesto', 'tresfera_organizaciones_');
    }
}

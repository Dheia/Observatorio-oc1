<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaOrganizacionesDepartamento extends Migration
{
    public function up()
    {
        Schema::rename('tresfera_organizaciones_', 'tresfera_organizaciones_departamento');
    }
    
    public function down()
    {
        Schema::rename('tresfera_organizaciones_departamento', 'tresfera_organizaciones_');
    }
}

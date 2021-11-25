<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaOrganizacionesDepartamento2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_organizaciones_departamento', function($table)
        {
            $table->integer('parent_id');
            $table->integer('localizacion_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_organizaciones_departamento', function($table)
        {
            $table->dropColumn('parent_id');
            $table->dropColumn('localizacion_id');
        });
    }
}

<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaOrganizacionesDepartamento5 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_organizaciones_departamento', function($table)
        {
            $table->integer('nest_right');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_organizaciones_departamento', function($table)
        {
            $table->dropColumn('nest_right');
        });
    }
}

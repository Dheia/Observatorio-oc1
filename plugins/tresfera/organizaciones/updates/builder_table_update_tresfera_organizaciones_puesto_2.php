<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaOrganizacionesPuesto2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_organizaciones_puesto', function($table)
        {
            $table->integer('empresa_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_organizaciones_puesto', function($table)
        {
            $table->dropColumn('empresa_id');
        });
    }
}

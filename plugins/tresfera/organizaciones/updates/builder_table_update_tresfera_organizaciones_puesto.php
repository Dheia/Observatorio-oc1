<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaOrganizacionesPuesto extends Migration
{
    public function up()
    {
        Schema::table('tresfera_organizaciones_puesto', function($table)
        {
            $table->integer('nest_left');
            $table->integer('nest_right');
            $table->integer('nest_depth');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_organizaciones_puesto', function($table)
        {
            $table->dropColumn('nest_left');
            $table->dropColumn('nest_right');
            $table->dropColumn('nest_depth');
        });
    }
}

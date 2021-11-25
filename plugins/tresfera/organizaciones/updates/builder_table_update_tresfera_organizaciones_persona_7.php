<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaOrganizacionesPersona7 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_organizaciones_persona', function($table)
        {
            $table->smallInteger('empresa_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_organizaciones_persona', function($table)
        {
            $table->dropColumn('empresa_id');
        });
    }
}

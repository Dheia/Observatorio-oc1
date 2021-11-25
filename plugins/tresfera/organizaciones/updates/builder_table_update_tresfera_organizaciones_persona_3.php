<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaOrganizacionesPersona3 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_organizaciones_persona', function($table)
        {
            $table->renameColumn('responsable_id', 'parent_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_organizaciones_persona', function($table)
        {
            $table->renameColumn('parent_id', 'responsable_id');
        });
    }
}

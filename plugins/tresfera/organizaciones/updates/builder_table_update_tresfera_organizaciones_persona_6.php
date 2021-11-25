<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaOrganizacionesPersona6 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_organizaciones_persona', function($table)
        {
            $table->text('name');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_organizaciones_persona', function($table)
        {
            $table->dropColumn('name');
        });
    }
}

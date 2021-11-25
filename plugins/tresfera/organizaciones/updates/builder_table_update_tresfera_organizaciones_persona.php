<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaOrganizacionesPersona extends Migration
{
    public function up()
    {
        Schema::table('tresfera_organizaciones_persona', function($table)
        {
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_organizaciones_persona', function($table)
        {
            $table->dropColumn('user_id');
        });
    }
}

<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaOrganizacionesLocalizacion extends Migration
{
    public function up()
    {
        Schema::table('tresfera_organizaciones_localizacion', function($table)
        {
            $table->integer('client_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_organizaciones_localizacion', function($table)
        {
            $table->dropColumn('client_id');
        });
    }
}

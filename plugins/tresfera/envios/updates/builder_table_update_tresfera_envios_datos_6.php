<?php namespace Tresfera\Envios\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaEnviosDatos6 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_envios_datos', function($table)
        {
            $table->smallInteger('enviado_at');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_envios_datos', function($table)
        {
            $table->dropColumn('enviado_at');
        });
    }
}

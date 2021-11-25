<?php namespace Tresfera\Envios\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaEnviosDatos3 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_envios_datos', function($table)
        {
            $table->dateTime('enviar_at');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_envios_datos', function($table)
        {
            $table->dropColumn('enviar_at');
        });
    }
}

<?php namespace Tresfera\Envios\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaEnviosDatos8 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_envios_datos', function($table)
        {
            $table->smallInteger('enviado')->nullable(false)->unsigned(false)->default(0)->change();
            $table->dropColumn('enviado_at');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_envios_datos', function($table)
        {
            $table->dateTime('enviado')->nullable(false)->unsigned(false)->default('0000-00-00 00:00:00')->change();
            $table->smallInteger('enviado_at');
        });
    }
}

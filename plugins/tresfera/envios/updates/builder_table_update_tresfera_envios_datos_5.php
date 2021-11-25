<?php namespace Tresfera\Envios\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaEnviosDatos5 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_envios_datos', function($table)
        {
            $table->text('id_usuari');
            $table->text('es_home');
            $table->text('edat');
            $table->text('antiguetat');
            $table->text('servei');
            $table->text('es_familiar');
            $table->text('es_quota_parcial');
            $table->text('accessos_mes');
            $table->text('mobil');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_envios_datos', function($table)
        {
            $table->dropColumn('id_usuari');
            $table->dropColumn('es_home');
            $table->dropColumn('edat');
            $table->dropColumn('antiguetat');
            $table->dropColumn('servei');
            $table->dropColumn('es_familiar');
            $table->dropColumn('es_quota_parcial');
            $table->dropColumn('accessos_mes');
            $table->dropColumn('mobil');
        });
    }
}

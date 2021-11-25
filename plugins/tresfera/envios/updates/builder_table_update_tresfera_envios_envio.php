<?php namespace Tresfera\Envios\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaEnviosEnvio extends Migration
{
    public function up()
    {
        Schema::table('tresfera_envios_envio', function($table)
        {
            $table->integer('quiz_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_envios_envio', function($table)
        {
            $table->dropColumn('quiz_id');
        });
    }
}

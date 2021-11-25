<?php namespace Tresfera\Alertas\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaAlertasAlertas13 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_alertas_alertas', function($table)
        {
            $table->string('cuando');
            $table->integer('num_dias');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_alertas_alertas', function($table)
        {
            $table->dropColumn('cuando');
            $table->dropColumn('num_dias');
        });
    }
}

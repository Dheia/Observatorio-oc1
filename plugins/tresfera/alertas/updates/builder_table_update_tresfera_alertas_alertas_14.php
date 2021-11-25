<?php namespace Tresfera\Alertas\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaAlertasAlertas14 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_alertas_alertas', function($table)
        {
            $table->integer('num_dias')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_alertas_alertas', function($table)
        {
            $table->integer('num_dias')->nullable(false)->change();
        });
    }
}

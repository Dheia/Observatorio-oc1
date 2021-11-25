<?php namespace Tresfera\Alertas\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaAlertasAlertas6 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_alertas_alertas', function($table)
        {
            $table->dropColumn('name');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_alertas_alertas', function($table)
        {
            $table->smallInteger('name');
        });
    }
}

<?php namespace Tresfera\Alertas\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaAlertasAlertas3 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_alertas_alertas', function($table)
        {
            $table->renameColumn('action', 'actions');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_alertas_alertas', function($table)
        {
            $table->renameColumn('actions', 'action');
        });
    }
}

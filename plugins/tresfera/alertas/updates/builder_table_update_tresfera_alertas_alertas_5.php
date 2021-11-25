<?php namespace Tresfera\Alertas\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaAlertasAlertas5 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_alertas_alertas', function($table)
        {
            $table->renameColumn('mailt_to', 'mail_to');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_alertas_alertas', function($table)
        {
            $table->renameColumn('mail_to', 'mailt_to');
        });
    }
}

<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupProyecto5 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_proyecto', function($table)
        {
            $table->integer('gestor_id')->unsigned()->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_proyecto', function($table)
        {
            $table->integer('gestor_id')->unsigned(false)->change();
        });
    }
}

<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupProyecto7 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_proyecto', function($table)
        {
            $table->integer('gestor_id')->default(0)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_proyecto', function($table)
        {
            $table->integer('gestor_id')->default(null)->change();
        });
    }
}

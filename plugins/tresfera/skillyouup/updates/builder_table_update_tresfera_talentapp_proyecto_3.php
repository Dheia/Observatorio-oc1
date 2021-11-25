<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupProyecto3 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_proyecto', function($table)
        {
            $table->integer('empresa_id')->nullable()->change();
            $table->integer('estado')->default(0)->change();
            $table->integer('gestor_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_proyecto', function($table)
        {
            $table->integer('empresa_id')->nullable(false)->change();
            $table->integer('estado')->default(null)->change();
            $table->integer('gestor_id')->nullable(false)->change();
        });
    }
}

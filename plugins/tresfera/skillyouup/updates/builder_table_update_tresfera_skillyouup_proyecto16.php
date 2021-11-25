<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupProyecto16 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_proyecto', function($table)
        {
            $table->string('periodicidad')->nullable(false)->default('none')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_proyecto', function($table)
        {
            $table->string('periodicidad', 191)->nullable()->default(null)->change();
        });
    }
}
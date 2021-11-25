<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupProyecto15 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_proyecto', function($table)
        {
            $table->string('periodicidad')->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_proyecto', function($table)
        {
            $table->string('periodicidad', 191)->default('0')->change();
        });
    }
}

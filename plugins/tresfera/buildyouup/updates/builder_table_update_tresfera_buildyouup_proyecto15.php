<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupProyecto15 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_proyecto', function($table)
        {
            $table->string('periodicidad')->default(null)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_proyecto', function($table)
        {
            $table->string('periodicidad', 191)->default('0')->change();
        });
    }
}
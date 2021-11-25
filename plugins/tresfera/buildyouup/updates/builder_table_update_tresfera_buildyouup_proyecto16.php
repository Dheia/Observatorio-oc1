<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupProyecto16 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_proyecto', function($table)
        {
            $table->string('periodicidad')->nullable(false)->default('none')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_proyecto', function($table)
        {
            $table->string('periodicidad', 191)->nullable()->default(null)->change();
        });
    }
}
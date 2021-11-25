<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupProyecto8 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_proyecto', function($table)
        {
            $table->integer('client_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_proyecto', function($table)
        {
            $table->dropColumn('client_id');
        });
    }
}

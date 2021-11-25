<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupProyecto8 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_proyecto', function($table)
        {
            $table->integer('client_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_proyecto', function($table)
        {
            $table->dropColumn('client_id');
        });
    }
}

<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupProyecto2 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_proyecto', function($table)
        {
            $table->integer('estado');
            $table->integer('gestor_id');
            $table->renameColumn('user_id', 'empresa_id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_proyecto', function($table)
        {
            $table->dropColumn('estado');
            $table->dropColumn('gestor_id');
            $table->renameColumn('empresa_id', 'user_id');
        });
    }
}

<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupEvaluacion8 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_evaluacion', function($table)
        {
            $table->integer('estado')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_evaluacion', function($table)
        {
            $table->dropColumn('estado');
        });
    }
}

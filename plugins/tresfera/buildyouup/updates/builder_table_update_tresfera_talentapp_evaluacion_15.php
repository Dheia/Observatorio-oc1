<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupEvaluacion15 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_evaluacion', function($table)
        {
            $table->text('stats');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_evaluacion', function($table)
        {
            $table->dropColumn('stats');
        });
    }
}

<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupEvaluacion13 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_evaluacion', function($table)
        {
            $table->boolean('is_autogestionado')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_evaluacion', function($table)
        {
            $table->dropColumn('is_autogestionado');
        });
    }
}

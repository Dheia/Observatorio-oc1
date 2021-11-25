<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupEvaluacionEvaluador5 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_evaluacion_evaluador', function($table)
        {
            $table->string('evaluador')->change();
         //   $table->primary('id');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_evaluacion_evaluador', function($table)
        {
        //    $table->dropPrimary('id');
            $table->string('evaluador', 191)->change();
        });
    }
}

<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupEvaluacionEvaluador7 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_evaluacion_evaluador', function($table)
        {
            $table->boolean('completado')->default(0);
            $table->string('evaluador')->change();
            $table->string('tipo')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_evaluacion_evaluador', function($table)
        {
            $table->dropColumn('completado');
            $table->string('evaluador', 191)->change();
            $table->string('tipo', 191)->change();
        });
    }
}

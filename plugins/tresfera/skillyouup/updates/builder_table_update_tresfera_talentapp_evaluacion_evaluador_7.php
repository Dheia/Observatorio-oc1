<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupEvaluacionEvaluador7 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_evaluacion_evaluador', function($table)
        {
            $table->boolean('completado')->default(0);
            $table->string('evaluador')->change();
            $table->string('tipo')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_evaluacion_evaluador', function($table)
        {
            $table->dropColumn('completado');
            $table->string('evaluador', 191)->change();
            $table->string('tipo', 191)->change();
        });
    }
}

<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupEvaluacionEvaluador6 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_evaluacion_evaluador', function($table)
        {
            $table->string('tipo');
            $table->string('evaluador')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_evaluacion_evaluador', function($table)
        {
            $table->dropColumn('tipo');
            $table->string('evaluador', 191)->change();
        });
    }
}

<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappEvaluacionEvaluador7 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_evaluacion_evaluador', function($table)
        {
            $table->boolean('completado')->default(0);
            $table->string('evaluador')->change();
            $table->string('tipo')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_evaluacion_evaluador', function($table)
        {
            $table->dropColumn('completado');
            $table->string('evaluador', 191)->change();
            $table->string('tipo', 191)->change();
        });
    }
}

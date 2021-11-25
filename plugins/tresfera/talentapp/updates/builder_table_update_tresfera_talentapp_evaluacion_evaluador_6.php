<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappEvaluacionEvaluador6 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_evaluacion_evaluador', function($table)
        {
            $table->string('tipo');
            $table->string('evaluador')->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_evaluacion_evaluador', function($table)
        {
            $table->dropColumn('tipo');
            $table->string('evaluador', 191)->change();
        });
    }
}

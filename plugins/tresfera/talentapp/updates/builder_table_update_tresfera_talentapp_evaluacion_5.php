<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappEvaluacion5 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->integer('cuestionario_evaluado_id')->nullable()->change();
            $table->integer('cuestionario_evaluador_id')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_evaluacion', function($table)
        {
            $table->integer('cuestionario_evaluado_id')->nullable(false)->change();
            $table->integer('cuestionario_evaluador_id')->nullable(false)->change();
        });
    }
}

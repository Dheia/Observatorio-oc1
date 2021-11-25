<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentappEvaluacion extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talentapp_evaluacion', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('proyecto_id');
            $table->integer('evaluado_id');
            $table->integer('cuestionario_evaluado_id');
            $table->integer('cuestionario_evaluador_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_talentapp_evaluacion');
    }
}

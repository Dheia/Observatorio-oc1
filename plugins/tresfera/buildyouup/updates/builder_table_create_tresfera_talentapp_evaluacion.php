<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaBuildyouupEvaluacion extends Migration
{
    public function up()
    {
        Schema::create('tresfera_buildyouup_evaluacion', function($table)
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
        Schema::dropIfExists('tresfera_buildyouup_evaluacion');
    }
}

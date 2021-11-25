<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaSkillyouupEvaluacion extends Migration
{
    public function up()
    {
        Schema::create('tresfera_skillyouup_evaluacion', function($table)
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
        Schema::dropIfExists('tresfera_skillyouup_evaluacion');
    }
}

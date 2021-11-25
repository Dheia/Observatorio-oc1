<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupEvaluacionEvaluador extends Migration
{
    public function up()
    {
        Schema::create('tresfera_skillyouup_evaluacion_evaluador', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('ev')->unsigned();
            $table->integer('evr')->unsigned();
            //$table->primary('id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_skillyouup_evaluacion_evaluador');


    }
}

<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappEvaluacionEvaluador extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talentapp_evaluacion_evaluador', function($table)
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
        Schema::dropIfExists('tresfera_talentapp_evaluacion_evaluador');


    }
}

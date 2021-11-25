<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentappCuestionario2 extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talentapp_cuestionario', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('preguntas');
            $table->integer('evaluacion_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_talentapp_cuestionario');
    }
}

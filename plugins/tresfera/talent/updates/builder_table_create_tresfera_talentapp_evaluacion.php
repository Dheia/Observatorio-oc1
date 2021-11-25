<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentEvaluacion extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talent_evaluacion', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('proyecto_id')->unsigned();
            $table->string('name');
            $table->string('password');
            $table->string('email');
            $table->integer('user_id')->unsigned();
            $table->text('params');
            $table->text('stats');
            $table->string('lang');
            $table->integer('client_id')->unsigned();
            $table->integer('estado_informe');
            $table->integer('rapport_id')->unsigned();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_talent_evaluacion');
    }
}

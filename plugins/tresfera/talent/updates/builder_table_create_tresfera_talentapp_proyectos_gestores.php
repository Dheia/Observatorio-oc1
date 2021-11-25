<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentProyectosGestores extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talent_proyectos_gestores', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->integer('user_id')->unsigned();
            $table->integer('proyecto_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_talent_proyectos_gestores');
    }
}

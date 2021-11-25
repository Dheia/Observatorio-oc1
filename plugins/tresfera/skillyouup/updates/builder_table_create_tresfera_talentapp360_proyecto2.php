<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaSkillyouupProyecto2 extends Migration
{
    public function up()
    {
        Schema::create('tresfera_skillyouup_proyecto', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->integer('tipo');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
            $table->integer('num_licencias');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_skillyouup_proyecto');
    }
}
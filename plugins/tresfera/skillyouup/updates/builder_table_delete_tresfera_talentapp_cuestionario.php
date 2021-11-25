<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaSkillyouupCuestionario extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_skillyouup_cuestionario');
    }
    
    public function down()
    {
        Schema::create('tresfera_skillyouup_cuestionario', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('empresa_id');
        });
    }
}

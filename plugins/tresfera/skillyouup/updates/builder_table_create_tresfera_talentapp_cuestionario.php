<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaSkillyouupCuestionario extends Migration
{
    public function up()
    {
        Schema::create('tresfera_skillyouup_cuestionario', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('empresa_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_skillyouup_cuestionario');
    }
}

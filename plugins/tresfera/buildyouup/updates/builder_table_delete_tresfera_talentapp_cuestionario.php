<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaBuildyouupCuestionario extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_buildyouup_cuestionario');
    }
    
    public function down()
    {
        Schema::create('tresfera_buildyouup_cuestionario', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('empresa_id');
        });
    }
}

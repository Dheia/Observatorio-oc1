<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaBuildyouupCuestionario extends Migration
{
    public function up()
    {
        Schema::create('tresfera_buildyouup_cuestionario', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('empresa_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_buildyouup_cuestionario');
    }
}

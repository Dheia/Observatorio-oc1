<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaBuildyouupRespuestas extends Migration
{
    public function up()
    {
        Schema::create('tresfera_buildyouup_respuestas', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->text('respuestas');
            $table->integer('cuestionario_id');
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_buildyouup_respuestas');
    }
}

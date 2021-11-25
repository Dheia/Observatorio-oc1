<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaTalentappCuestionario extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_talentapp_cuestionario');
    }
    
    public function down()
    {
        Schema::create('tresfera_talentapp_cuestionario', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('empresa_id');
        });
    }
}

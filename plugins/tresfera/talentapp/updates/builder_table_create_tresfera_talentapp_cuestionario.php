<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentappCuestionario extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talentapp_cuestionario', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('empresa_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_talentapp_cuestionario');
    }
}

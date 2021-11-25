<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentappRespuestas extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talentapp_respuestas', function($table)
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
        Schema::dropIfExists('tresfera_talentapp_respuestas');
    }
}

<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaTalentappUserEvaluado extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_talentapp_user_evaluado');
    }
    
    public function down()
    {
        Schema::create('tresfera_talentapp_user_evaluado', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
        });
    }
}

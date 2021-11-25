<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaTalentappUserEvaluador extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_talentapp_user_evaluador');
    }
    
    public function down()
    {
        Schema::create('tresfera_talentapp_user_evaluador', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
        });
    }
}

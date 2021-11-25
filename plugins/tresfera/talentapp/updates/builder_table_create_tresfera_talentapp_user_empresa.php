<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentappUserEmpresa extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talentapp_user_empresa', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
            $table->string('logo');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_talentapp_user_empresa');
    }
}

<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaTalentappUserEmpresa extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_talentapp_user_empresa');
    }
    
    public function down()
    {
        Schema::create('tresfera_talentapp_user_empresa', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
            $table->string('logo', 191);
        });
    }
}

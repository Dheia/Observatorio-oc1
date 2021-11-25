<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaSkillyouupUserEmpresa extends Migration
{
    public function up()
    {
        Schema::create('tresfera_skillyouup_user_empresa', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
            $table->string('logo');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_skillyouup_user_empresa');
    }
}

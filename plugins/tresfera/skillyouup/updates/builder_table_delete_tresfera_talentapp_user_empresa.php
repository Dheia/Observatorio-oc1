<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaSkillyouupUserEmpresa extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_skillyouup_user_empresa');
    }
    
    public function down()
    {
        Schema::create('tresfera_skillyouup_user_empresa', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
            $table->string('logo', 191);
        });
    }
}

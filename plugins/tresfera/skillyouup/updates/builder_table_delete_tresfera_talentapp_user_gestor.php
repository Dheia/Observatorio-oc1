<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaSkillyouupUserGestor extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_skillyouup_user_gestor');
    }
    
    public function down()
    {
        Schema::create('tresfera_skillyouup_user_gestor', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
        });
    }
}

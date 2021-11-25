<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaSkillyouupUserEvaluado extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_skillyouup_user_evaluado');
    }
    
    public function down()
    {
        Schema::create('tresfera_skillyouup_user_evaluado', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
        });
    }
}

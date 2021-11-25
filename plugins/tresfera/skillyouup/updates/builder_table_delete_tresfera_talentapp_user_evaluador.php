<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaSkillyouupUserEvaluador extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_skillyouup_user_evaluador');
    }
    
    public function down()
    {
        Schema::create('tresfera_skillyouup_user_evaluador', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
        });
    }
}

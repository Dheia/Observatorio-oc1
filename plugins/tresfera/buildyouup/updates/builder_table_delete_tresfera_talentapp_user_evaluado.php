<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaBuildyouupUserEvaluado extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_buildyouup_user_evaluado');
    }
    
    public function down()
    {
        Schema::create('tresfera_buildyouup_user_evaluado', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
        });
    }
}

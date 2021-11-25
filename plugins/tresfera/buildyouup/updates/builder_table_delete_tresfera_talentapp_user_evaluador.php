<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaBuildyouupUserEvaluador extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_buildyouup_user_evaluador');
    }
    
    public function down()
    {
        Schema::create('tresfera_buildyouup_user_evaluador', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
        });
    }
}

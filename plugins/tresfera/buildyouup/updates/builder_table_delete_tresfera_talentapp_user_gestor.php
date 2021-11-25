<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteTresferaBuildyouupUserGestor extends Migration
{
    public function up()
    {
        Schema::dropIfExists('tresfera_buildyouup_user_gestor');
    }
    
    public function down()
    {
        Schema::create('tresfera_buildyouup_user_gestor', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
        });
    }
}

<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaBuildyouupUserGestor extends Migration
{
    public function up()
    {
        Schema::create('tresfera_buildyouup_user_gestor', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_buildyouup_user_gestor');
    }
}

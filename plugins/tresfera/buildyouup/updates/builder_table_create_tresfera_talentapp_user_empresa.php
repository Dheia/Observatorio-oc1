<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaBuildyouupUserEmpresa extends Migration
{
    public function up()
    {
        Schema::create('tresfera_buildyouup_user_empresa', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id');
            $table->string('logo');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_buildyouup_user_empresa');
    }
}

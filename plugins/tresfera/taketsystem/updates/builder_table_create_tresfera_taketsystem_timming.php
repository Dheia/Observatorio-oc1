<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTaketsystemTimming extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_timming', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->integer('user_id');
            $table->string('page');
            $table->integer('time');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_timming');
    }
}

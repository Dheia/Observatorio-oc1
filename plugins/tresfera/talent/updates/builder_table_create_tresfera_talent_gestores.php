<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentGestores extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talent_gestores', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->text('name');
            $table->text('email');
            $table->integer('user_id');
            $table->integer('proyecto_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_talent_gestores');
    }
}

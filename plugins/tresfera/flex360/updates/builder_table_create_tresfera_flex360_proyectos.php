<?php namespace Tresfera\Flex360\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaFlex360Proyectos extends Migration
{
    public function up()
    {
        Schema::create('tresfera_flex360_proyectos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->text('name');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->integer('client_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_flex360_proyectos');
    }
}

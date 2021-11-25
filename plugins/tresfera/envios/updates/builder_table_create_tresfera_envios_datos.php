<?php namespace Tresfera\Envios\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaEnviosDatos extends Migration
{
    public function up()
    {
        Schema::create('tresfera_envios_datos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('email');
            $table->string('club');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_envios_datos');
    }
}

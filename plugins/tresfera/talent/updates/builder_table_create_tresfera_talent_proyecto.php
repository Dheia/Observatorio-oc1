<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentProyecto extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talent_proyecto', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->integer('num_licencias')->nullable();
            $table->text('description');
            $table->string('email')->nullable();
            $table->string('lang')->default('es');
            $table->string('periodicidad')->default('none');
            $table->integer('estado')->default(0);
            $table->integer('client_id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_talent_proyecto');
    }
}
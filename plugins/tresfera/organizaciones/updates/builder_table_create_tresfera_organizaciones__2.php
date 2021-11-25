<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaOrganizaciones2 extends Migration
{
    public function up()
    {
        Schema::create('tresfera_organizaciones_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('persona_id');
            $table->integer('puesto_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_organizaciones_');
    }
}

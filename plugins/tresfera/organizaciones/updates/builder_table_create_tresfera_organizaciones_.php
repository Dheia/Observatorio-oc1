<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaOrganizaciones extends Migration
{
    public function up()
    {
        Schema::create('tresfera_organizaciones_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->text('name');
            $table->integer('empresa_id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_organizaciones_');
    }
}

<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaOrganizacionesLocalizacion extends Migration
{
    public function up()
    {
        Schema::create('tresfera_organizaciones_localizacion', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->text('name');
            $table->text('direction');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_organizaciones_localizacion');
    }
}

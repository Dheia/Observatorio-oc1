<?php namespace Tresfera\Organizaciones\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaOrganizacionesEmpresa extends Migration
{
    public function up()
    {
        Schema::create('tresfera_organizaciones_empresa', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_organizaciones_empresa');
    }
}

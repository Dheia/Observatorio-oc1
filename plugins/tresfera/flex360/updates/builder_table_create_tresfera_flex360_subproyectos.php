<?php namespace Tresfera\Flex360\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaFlex360Subproyectos extends Migration
{
    public function up()
    {
        Schema::create('tresfera_flex360_subproyectos', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->text('name');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_flex360_subproyectos');
    }
}

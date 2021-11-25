<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaSkillyouupRapports extends Migration
{
    public function up()
    {
        Schema::create('tresfera_skillyouup_rapports', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('evaluacion_id');
            $table->string('data');
            $table->dateTime('generated_at');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_skillyouup_rapports');
    }
}

<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentRapports extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talent_rapports', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('evaluacion_id')->unsigned();
            $table->string('data');
            $table->dateTime('generated_at');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_talent_rapports');
    }
}

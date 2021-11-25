<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentappRapports extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talentapp_rapports', function($table)
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
        Schema::dropIfExists('tresfera_talentapp_rapports');
    }
}

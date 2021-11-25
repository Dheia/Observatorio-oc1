<?php namespace Tresfera\Talent\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTalentResults extends Migration
{
    public function up()
    {
        Schema::create('tresfera_talent_results', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->integer('quiz_id')->unsigned();
            $table->integer('device_id')->nullable()->unsigned();
            $table->integer('shop_id')->nullable()->unsigned();
            $table->integer('region_id')->nullable()->unsigned();
            $table->integer('city_id')->nullable()->unsigned();
            $table->integer('evaluacion_id')->unsigned();
            $table->string('sex')->nullable();
            $table->string('genero')->nullable();
            $table->string('age')->nullable();
            $table->string('edad')->nullable();
            $table->string('cp')->nullable();
            $table->string('free')->nullable();
            $table->string('rol')->nullable();
            $table->string('area')->nullable();
            $table->string('sector')->nullable();
            $table->string('email')->nullable();
            $table->integer('completed')->unsigned();
            $table->string('function')->nullable();
            $table->integer('import')->default(0);
            $table->integer('duplicated')->default(0);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_talent_results');
    }
}

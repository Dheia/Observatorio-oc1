<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaTaketsystemProgresosAnswers extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_progresos_answers', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('quiz');
            $table->string('pag');
            $table->string('question');
            $table->string('value');
            $table->string('ponts');
            $table->string('proyecto');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_progresos_answers');
    }
}

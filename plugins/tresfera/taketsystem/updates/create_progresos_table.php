<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateProgresosTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_progresos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_progresos');
    }
}

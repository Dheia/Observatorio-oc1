<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_clients', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('max_devices')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_clients');
    }
}

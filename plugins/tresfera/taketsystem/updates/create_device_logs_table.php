<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateDeviceLogsTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_device_logs', function ($table) {
            $table->increments('id');
            $table->integer('device_id')->unsigned()->references('id')->on('tresfera_taketsystem_devices')->onDelete('cascade');
            $table->string('action');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_device_logs');
    }
}

<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateDevicesTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_devices', function ($table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->references('id')->on('tresfera_taketsystem_clients')->onDelete('cascade');
            $table->integer('shop_id')->nullable()->unsigned()->references('id')->on('tresfera_taketsystem_shops')->onDelete('set null');
            $table->integer('city_id')->nullable()->unsigned()->references('id');
            $table->integer('region_id')->nullable()->unsigned()->references('id');
            $table->string('mac')->unique();
            $table->string('push_token')->nullable()->unique();
            $table->string('token')->nullable()->unique();
            $table->timestamp('last_request')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_devices');
    }
}

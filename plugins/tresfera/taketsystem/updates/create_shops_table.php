<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateShopsTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_shops', function ($table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->references('id')->on('tresfera_taketsystem_shops')->onDelete('cascade');
            $table->integer('city_id')->nullable()->unsigned()->references('id')->on('tresfera_taketsystem_cities')->onDelete('set null');
            $table->string('name');
            $table->string('secret')->unique();
            $table->integer('postcode')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_shops');
    }
}

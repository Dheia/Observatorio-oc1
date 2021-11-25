<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateResultsTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_results', function ($table) {
            $table->increments('id');
            $table->integer('quiz_id')->unsigned()->references('id')->on('tresfera_taketsystem_quizzes')->onDelete('cascade');
            $table->integer('device_id')->nullable()->unsigned()->references('id')->on('tresfera_taketsystem_devices')->onDelete('set null');
            $table->integer('shop_id')->nullable()->unsigned()->references('id')->on('tresfera_taketsystem_shops')->onDelete('set null');
            $table->integer('region_id')->nullable()->unsigned()->references('id')->on('tresfera_taketsystem_regions')->onDelete('set null');
            $table->integer('city_id')->nullable()->unsigned()->references('id')->on('tresfera_taketsystem_cities')->onDelete('set null');
            $table->integer('completed')->unsigned();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_results');
    }
}

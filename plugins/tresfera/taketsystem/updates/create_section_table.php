<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateSectionsTable extends Migration
{
    public function up()
    {
        Schema::create('tresfera_taketsystem_sections', function ($table) {
            $table->increments('id');
            $table->integer('sector_id')->unsigned()->references('id')->on('tresfera_taketsystem_sectors')->onDelete('cascade');
            $table->string('title');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_taketsystem_sections');
    }
}

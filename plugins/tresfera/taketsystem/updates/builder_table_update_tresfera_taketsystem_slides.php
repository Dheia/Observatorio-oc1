<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemSlides extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_slides', function($table)
        {
            $table->text('campos')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_slides', function($table)
        {
            $table->dropColumn('campos');
        });
    }
}

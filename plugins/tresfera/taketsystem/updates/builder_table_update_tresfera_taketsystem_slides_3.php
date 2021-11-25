<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemSlides3 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_slides', function($table)
        {
            $table->text('code')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_slides', function($table)
        {
            $table->dropColumn('code');
        });
    }
}

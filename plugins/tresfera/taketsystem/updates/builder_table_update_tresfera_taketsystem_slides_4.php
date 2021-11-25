<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemSlides4 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_slides', function($table)
        {
            $table->renameColumn('campo', 'campos');
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_slides', function($table)
        {
            $table->renameColumn('campos', 'campo');
        });
    }
}

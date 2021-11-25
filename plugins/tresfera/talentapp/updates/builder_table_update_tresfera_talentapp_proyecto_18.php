<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTalentappProyecto18 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_talentapp_proyecto', function($table)
        {
            $table->string('periodicidad')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_talentapp_proyecto', function($table)
        {
            $table->string('periodicidad', 191)->nullable(false)->change();
        });
    }
}

<?php namespace Tresfera\Buildyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaBuildyouupRapports extends Migration
{
    public function up()
    {
        Schema::table('tresfera_buildyouup_rapports', function($table)
        {
            $table->string('data', 1000)->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_buildyouup_rapports', function($table)
        {
            $table->string('data', 191)->change();
        });
    }
}

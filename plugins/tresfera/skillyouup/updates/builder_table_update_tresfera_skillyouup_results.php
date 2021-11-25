<?php namespace Tresfera\Skillyouup\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaSkillyouupResults extends Migration
{
    public function up()
    {
        Schema::table('tresfera_skillyouup_results', function($table)
        {
            $table->boolean('is_evaluacion')->default(1);
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_skillyouup_results', function($table)
        {
            $table->dropColumn('is_evaluacion');
        });
    }
}

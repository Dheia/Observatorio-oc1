<?php namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaTaketsystemResults5 extends Migration
{
    public function up()
    {
        Schema::table('tresfera_taketsystem_results', function($table)
        {
            $table->integer('duplicated')->nullable()->default(0);
            $table->integer('import')->nullable()->change();
        });
    }
    
    public function down()
    {
        Schema::table('tresfera_taketsystem_results', function($table)
        {
            $table->dropColumn('duplicated');
            $table->integer('import')->nullable(false)->change();
        });
    }
}

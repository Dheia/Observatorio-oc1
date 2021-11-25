<?php namespace Tresfera\Talentapp\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class Migration1042 extends Migration
{
    public function up()
    {
        // Schema::create('tresfera_talentapp_table', function($table)
        // {
        // });
        Schema::table('backend_users', function($table)
        {
            $table->integer('empresa_id')->unsigned();
         //   $table->primary('id');
        });
    }

    public function down()
    {
        // Schema::drop('tresfera_talentapp_table');
        Schema::table('backend_users', function($table)
        {
            $table->dropColumn('empresa_id');
         //   $table->primary('id');
        });
    }
}
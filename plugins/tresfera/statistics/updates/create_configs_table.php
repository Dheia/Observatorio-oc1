<?php namespace Tresfera\Statistics\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateConfigsTable extends Migration
{

    public function up()
    {
        Schema::create('tresfera_statistics_configs', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tresfera_statistics_configs');
    }

}

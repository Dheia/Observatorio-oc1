<?php namespace Tresfera\Clients\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateTresferaClients extends Migration
{
    public function up()
    {
        Schema::create('tresfera_clients_', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('tresfera_clients_');
    }
}

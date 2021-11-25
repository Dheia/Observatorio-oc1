<?php namespace Tresfera\Clients\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateTresferaClientsClients extends Migration
{
    public function up()
    {
        Schema::rename('tresfera_clients_', 'tresfera_clients_clients');
        Schema::table('tresfera_clients_clients', function($table)
        {
            $table->increments('id')->unsigned(false)->change();
        });
    }
    
    public function down()
    {
        Schema::rename('tresfera_clients_clients', 'tresfera_clients_');
        Schema::table('tresfera_clients_', function($table)
        {
            $table->increments('id')->unsigned()->change();
        });
    }
}

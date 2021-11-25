<?php

namespace Tresfera\Taketsystem\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UsersAddClient extends Migration
{
    public function up()
    {
        Schema::table('backend_users', function ($table) {
            $table->integer('client_id')->nullable()->unsigned()->references('id')->on('tresfera_taketsystem_clients')->onDelete('set null');
        });
    }
    public function down()
    {
        Schema::table('backend_users', function ($table) {
            $table->dropColumn('client_id');
        });
    }
}

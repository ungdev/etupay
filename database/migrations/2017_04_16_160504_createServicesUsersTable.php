<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_users', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('service_id');
            $table->enum('right', ['write', 'read']);
            $table->timestamps();
            $table->index(['user_id', 'service_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('services_users');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('host')->unique();
            $table->string('api_key')->unique();
            $table->integer('fundation_id')->unsigned();
            $table->string('return_url');
            $table->string('cancel_url');
            $table->string('callback_url');
            $table->boolean('isDisabled')->default(false);
            $table->timestamps();

            $table->foreign('fundation_id')
                ->references('id')->on('fundations')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('services');
    }
}

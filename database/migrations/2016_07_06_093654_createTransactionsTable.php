<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('service_id')->unsigned()->nullable();
            $table->string('bank_transaction_id')->nullable();
            $table->integer('amount')->unsigned();
            $table->text('data')->nullable();
            $table->text('description')->nullable();
            $table->string('client_mail')->nullable();
            $table->enum('type', ['PAYMENT', 'AUTHORISATION'])->default('PAYMENT');
            $table->enum('step', ['INITIALISED', 'PAID', 'REFUSED', 'REFUNDED', 'AUTHORISATION', 'CANCELED'])->default('INITIALISED');
            $table->integer('capture_day')->unsigned()->default(0);
            $table->text('service_data')->nullable();
            $table->timestamps();

            $table->foreign('service_id')
                ->references('id')->on('services')
                ->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactions');
    }
}

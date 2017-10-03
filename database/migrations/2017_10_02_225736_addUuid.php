<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Ramsey\Uuid\Uuid;

class AddUuid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasColumn('transactions','uuid')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->uuid('uuid')->after('id')->nullable();
            });
        }


        $transactions = \App\Models\Transaction::all();
        foreach ($transactions as $transaction)
        {
            $transaction->uuid = Uuid::uuid4()->toString();
            $transaction->save();
        }
        Schema::table('transactions', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->removeColumn('uuid');
        });
    }
}

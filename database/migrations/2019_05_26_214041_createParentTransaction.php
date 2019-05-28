<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use \App\Models\Transaction;

class CreateParentTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //if (!Schema::hasColumn('transactions', 'parent')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->integer('parent')->unsigned()->nullable()->after('id');
                $table->foreign('parent')->references('id')->on('transactions');

                //TODO add refund transaction type
            });
            DB::statement("ALTER TABLE transactions CHANGE COLUMN `type` `type` ENUM('PAYMENT', 'AUTHORISATION', 'REFUND')");
        //}

        //Migration script

        $transactions = Transaction::where('step', 'REFUNDED')->whereNull('parent')->get();
        foreach ($transactions as $transaction) {
            $tr_new = new Transaction();
            $tr_new->parent = $transaction->id;
            $tr_new->amount = $transaction->amount;
            $tr_new->provider = $transaction->provider;
            $tr_new->step = 'PAID';
            $tr_new->type = 'REFUND';
            $tr_new->created_at = $transaction->updated_at;

            $tr_new->save();

            $transaction->step = 'PAID';
            $transaction->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->removeColumn('parent');
        });
    }
}

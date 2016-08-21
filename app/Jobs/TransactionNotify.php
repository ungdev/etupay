<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Transaction;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionNotify extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $transaction;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Transaction $transaction)
    {
        //Notify Serveur
        dispatch(new TransactionClientNotify($transaction));
        $this->sendMailNotification();

    }

    public function sendMailNotification()
    {
        if(!filter_var($this->transaction->client_mail, FILTER_VALIDATE_EMAIL))
            return false;

        switch ($this->transaction->step)
        {
            case 'PAID':
                break;

            case 'REFUSED':
                break;

            case 'CANCELED':
                break;
        }
    }
}

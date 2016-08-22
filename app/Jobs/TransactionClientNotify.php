<?php

namespace App\Jobs;


use App\Jobs\Job;
use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use App\Facades\PaymentLoader;

class TransactionClientNotify extends Job implements ShouldQueue
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

        $transaction = $this->transaction;
        // On fait la transaction
        $client  = new Client();
        $res = $client->request('POST',$transaction->service->callback_url,[
            'json' => [ 'payload' => PaymentLoader::encryptFromService($transaction->service, $transaction->callbackReturn()) ],
            'verify' => false,
        ]);
        if($res->getStatusCode() != 200)
            throw new \Exception($res->getStatusCode().' error during #'.$transaction->id.' callback');
    }
}

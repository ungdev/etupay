<?php

namespace App\Jobs;

use App\Classes\PaymentLoader;
use App\Jobs\Job;
use App\Models\Transaction;
use GuzzleHttp\Client;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

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
        // On fait la transaction
        Log::info('New Client notify request');
        $client  = new Client();
        $res = $client->request('POST',$transaction->service->callback_url,[
            'payload' => PaymentLoader::encryptFromService($transaction->service, $transaction->callbackReturn()),
        ]);
        if($res->getStatusCode() != 200)
            throw new \Exception($res->getStatusCode().' error during #'.$transaction->id.' callback');
    }
}

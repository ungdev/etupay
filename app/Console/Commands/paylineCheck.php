<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use App\PaymentProvider\PaylineProvider;
use Illuminate\Console\Command;

class paylineCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payline:check {--id=* : payline transaction id to force reconciliate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permet de réconsilier les transaction de la base avec Payline';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $opt_id = $this->option('id');
        $paylineProvider = new PaylineProvider();
        $updated = 0;

        if($opt_id)
        {
            foreach ($opt_id as $tr_id)
            {
                $tr = $paylineProvider->getTransactionByPaylineId($tr_id);
                if($tr)
                {
                    $etupay_id = (explode('_', $tr['order']['ref']))[1];
                    $transaction = Transaction::find($etupay_id);
                    if ($transaction)
                    {
                        $this->info('Processing callback transaction ' . $transaction->id);
                        $this->processTransaction($transaction, $tr);
                        $updated++;
                    } else {
                        $this->error("Transaction not found ! ".$tr['order']['ref']." Payline: ".$tr_id);
                    }
                }
            }

        } else {
            $transactions = Transaction::where('step', 'INITIALISED')->get();
            $this->info(count($transactions) . ' transaction initialisé.');
            $this->info('Lancement de la tentative de résolution avec Payline');

            $this->output->progressStart(count($transactions));
            foreach ($transactions as $transaction) {
                $tr = $paylineProvider->getTransaction($transaction->id);
                if ($tr) {
                    $this->info('Processing callback transaction ' . $transaction->id);
                    $this->processTransaction($transaction, $tr);
                    $updated++;
                }

                $this->output->progressAdvance();
            }
            $this->output->progressFinish();
        }

        $this->info('Nombre de transaction consilié: '.$updated);
    }

    private function processTransaction(Transaction $transaction, $tr)
    {
        $transaction->data = json_encode($tr);
        $transaction->bank_transaction_id = $tr['transaction']['id'];
        $transaction->provider = 'Payline';

        switch ($tr['result']['code'])
        {
            case '00000': // Accepted
            case '02400':
            case '02500':
            case '02501':
            case '02517':
            case '02520':
            case '02616':
            case '03000':
            case '04000':
                if($tr['payment']['amount'] != $transaction->amount)
                {
                    throw new \Exception('Discordance in transaction amount');
                    $transaction->save();
                    $this->error('Discordance in transaction amount '.$transaction->id);
                    return false;
                }
                $transaction->callbackAccepted();
                break;
            case '02324':
                //Transaction expiré
                $transaction->step = 'CANCELED';
                $transaction->save();
                break;
            default:
                $transaction->callbackRefused();

        }
        $transaction->save();
    }
}

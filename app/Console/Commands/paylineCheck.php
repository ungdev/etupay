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
    protected $signature = 'payline:check';

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
        $transactions = Transaction::where('step', 'INITIALISED')->get();
        $this->info(count($transactions).' transaction initialisé.');
        $this->info('Lancement de la tentative de résolution avec Payline');

        $paylineProvider = new PaylineProvider();
        $updated = 0;

        $this->output->progressStart(count($transactions));
        foreach ($transactions as $transaction)
        {
            $tr = $paylineProvider->getTransaction($transaction->id);
            if($tr)
            {
                $transaction->data = $tr;
                $transaction->bank_transaction_id = $tr['transaction']['id'];
                $transaction->provider = $this->getName();

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
                            Log::critical('Discordance in transaction amount '.$transaction->id);
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

                Log::info('Processing callback transaction '.$transaction->id);
                $transaction->save();
                $updated++;
            }
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();

        Log::info('Nombre de transaction consilié: '.$updated);
    }
}

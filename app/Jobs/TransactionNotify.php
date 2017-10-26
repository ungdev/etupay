<?php

namespace App\Jobs;

use App\Jobs\Job;
use App\Models\Transaction;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

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
        $this->sendMailNotification();

    }

    public function sendMailNotification()
    {
        if(!filter_var($this->transaction->client_mail, FILTER_VALIDATE_EMAIL))
            return false;

        switch ($this->transaction->step)
        {
            case 'PAID':
                $sujet = 'Confirmation de paiement, transaction n°'.$this->transaction->id;
                $template = 'emails.paid';
                break;

            case 'AUTHORISATION':
                break;

            case 'REFUSED':
                $sujet = 'Échec de la transaction';
                $template = 'emails.refused';
                break;

            case 'CANCELED':
                $sujet = 'Abandon de la transaction';
                $template = 'emails.refused';
                break;
        }

        if(isset($template) && view()->exists($template)) {
            $transaction = $this->transaction;

            Mail::queue($template, ['transaction' => $this->transaction, 'sujet' => $sujet], function ($m) use ($transaction, $sujet) {
                $m->from('etupay@utt.fr', 'Etupay - BDE UTT');
                $m->subject($sujet);
                $m->to($transaction->client_mail);
            });
        }
    }
}

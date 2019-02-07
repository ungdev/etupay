<?php

namespace App\Console\Commands;

use App\PaymentProvider\PaylineProvider;
use Illuminate\Console\Command;

class BatchRefund extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:batch-refund';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $p = new PaylineProvider();

        $ids = [];
        foreach ($ids as $id)
        {
            $tr = $p->doRefund($id);
            if (!$tr or $tr['result']['code'] != '00000')
            {
                $this->error('Refund of transaction '.$id.' failed.');
                dd($tr);
            } else $this->info('Transaction '.$id.' refunded.');

        }
    }
}

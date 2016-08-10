<?php

namespace App\Console\Commands;

use App\Models\Fundation;
use App\Models\Transaction;
use Illuminate\Console\Command;

class CreateFundation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fundations:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Can be use to create new fundation account';

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
        $fundation = new Fundation();

        $this->info('To create the new fundation, please answer the question below.');

        $fundation->name = $this->ask('Name of the fundation: ');
        $fundation->mail = $this->ask('eMail addr: ');

        if ($this->confirm('Do you wish to confirm? [y|N]')) {
            try
            {
                $fundation->save();
            }catch (\Exception $e)
            {
                $this->error('Error during creation.');
            }
            if($fundation->id)
                $this->info($fundation->name.' created with id:'.$fundation->id);
        }
    }
}

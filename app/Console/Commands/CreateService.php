<?php

namespace App\Console\Commands;

use App\Models\Fundation;
use App\Models\Service;
use Illuminate\Console\Command;

class CreateService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:create';

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
        $service = new Service();
        $service->generateApiKey();

        $this->info('Please answer to question below.');
        $this->info('Fundation registred: ');
        $this->table(['id','name'], Fundation::all(['id','name']));
        $service->fundation_id = $this->ask('Fundation ID: ');
        $service->host = $this->ask('Service server address: ', 'integration.uttnetgroup.fr');
        $service->return_url = $this->ask('Return url: ');
        $service->callback_url = $this->ask('Callback url: ');

        if ($this->confirm('Do you wish to confirm? [y|N]')) {
            try
            {
                $service->save();
            }catch (\Exception $e)
            {
                $this->error('Error during creation.');
            }
            if($service->id)
                $this->info($service->host.' service created with id:'.$service->id.' and API KEY: '.$service->api_key);
        }
    }
}

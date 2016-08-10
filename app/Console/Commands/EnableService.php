<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;

class EnableService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:enable {service_id} --on/off';

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
        $service = Service::findOrFail($this->argument('service_id'));
        if($this->hasOption('on'))
            $service->isDisabled = false;
        else if ($this->hasOption('off'))
            $service->isDisabled = true;
        else
            $this->error('No option specified --on or --off');

        $service->save();
        $this->info('Change done');
    }
}

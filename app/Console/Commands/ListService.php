<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;

class ListService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'services:list {--key}';

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
        $this->info('List of service');

        $column = ['id', 'host','isDisabled'];
        if($this->option('key'))
            $column[] = 'api_key';
        else $this->info('Use --key option to display api_key.');
        $this->table($column, Service::all($column)->toArray());
    }
}

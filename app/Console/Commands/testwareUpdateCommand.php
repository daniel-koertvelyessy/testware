<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class testwareUpdateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testware:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update testware database to new schema';

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
     * @return int
     */
    public function handle()
    {
        $this->info('Start working ... ');
        $output = '';
        \Artisan::call('migrate',[],$output);
        $this->info(\Artisan::output());
        return 0;
    }
}

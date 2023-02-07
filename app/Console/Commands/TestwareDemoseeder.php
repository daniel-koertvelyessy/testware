<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class TestwareDemoseeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testware:demoseeder
           {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Empty current database and fill it with demo datasets';

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
        if ($this->option('force')){
            $this->seedDatabase();
            return 0;
        }
        $this->error('                                                            ');
        $this->error('                        W A R N I N G                       ');
        $this->error('                                                            ');
        $this->error('          This seeder will reset your database!             ');
        $this->error('       All data will be lost and cannot be restored!        ');
        $this->error('                                                            ');

        if ($this->confirm('Type [yes] to proceed or [no] to exit without changes.', false)) {
           $this->seedDatabase();
            return 0;
        }
    }

    protected function seedDatabase(){
        $output = '';
        $this->info('* * * * *  Reset database and fill with Demo data');
        Artisan::call('migrate:fresh --seeder=DemodataSeeder', [], $output);
    }
}

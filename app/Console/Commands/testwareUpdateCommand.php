<?php

namespace App\Console\Commands;

use App\User;
use Artisan;
use Illuminate\Console\Command;

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
        //  $this->execPrint("git pull https://user:password@bitbucket.org/user/repo.git master");
        $update_git = $this->execPrint('git status');
        $output = '';
        Artisan::call('migrate', [], $output);
        $this->info(Artisan::output());

        return $update_git;
    }

    private function execPrint($command)
    {
        $result = [];
        exec($command, $result);
        $res = ('<pre>');
        foreach ($result as $line) {
            $res .= ($line."\n");
        }
        $res .= ('</pre>');

        return $res;
    }
}

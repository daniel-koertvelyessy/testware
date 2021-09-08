<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class testwareDbBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testware:dbbackup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a dump of the postgreSQL databse and store it';
    /**
     * @var Process
     */
    protected $process;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->process = Process::fromShellCommandline('docker-compose exec db pg_dump -U testWareDbUser -d testware > dump.sql');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!is_dir(storage_path('app/backups')))
            mkdir(storage_path('app/backups'));
        try {
            $this->info('The backup has been started');
            $this->process->mustRun();
            $this->info('The backup has been proceed successfully.');
        } catch (ProcessFailedException $exception) {
            logger()->error('Backup exception', compact('exception'));
            $this->error('The backup process has failed.');
        }
    }
}

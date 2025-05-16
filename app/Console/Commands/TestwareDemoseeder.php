<?php

namespace App\Console\Commands;

use App\User;
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
     */
    public function handle(): int
    {

        //    dd(getenv('APP_ENV'));

        if (getenv('APP_ENV') != 'demo') {

            if (! $this->loginSysAdmin()) {
                return 1;
            }
        }

        if ($this->option('force')) {
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

        return 1;
    }

    protected function seedDatabase(): void
    {
        $this->info('✓  Turning on maintenance mode');
        Artisan::call('down');
        $output = '';
        $this->info('✓  Reset database and fill with Demo data');
        Artisan::call('migrate:fresh --seeder=DemodataSeeder --force', [], $output);
        $this->info('✓  Task completed. Switching off maintenance mode');
        Artisan::call('up');

    }

    protected function loginSysAdmin(): bool
    {
        $this->warn('                                                            ');
        $this->warn('                        W A R N I N G                       ');
        $this->warn('                                                            ');
        $this->warn('     Your testware instance is not running in demo mode.    ');
        $this->warn('         Please use a SysAdmin account to continue.         ');
        $this->warn('                                                            ');

        $username = $this->ask('SysAdmin e-mail address');

        while (is_null($username)) {
            $this->warn('Please provide an e-mail address. Press Crtl and C to cancel seeder.');
            $username = $this->ask('e-mail address ');
        }

        for ($k = 0; $k < 3; $k++) {
            $password = $this->secret('Respective password ');
            while (is_null($password)) {
                $this->warn('Please provide the password of the chosen account. Press Crtl and C to cancel seeder.');
                $password = $this->secret('password ');
            }

            if ($this->verifySysAdmin($username, $password)) {
                return true;
            } else {
                $this->warn('Login failed');
            }

        }

        $this->warn('                           ');
        $this->error('                          ');
        $this->error('Too many incorrect login. ');
        $this->error('                          ');
        $this->error('Seeding command caneceld. ');

        return false;

    }

    protected function verifySysAdmin(string $email, string $password): bool
    {

        $user = User::select(['password', 'role_id'])->where('email', $email)->first();

        if ($user) {
            if ($user->role_id === 1) {
                return password_verify($password, $user->password);
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

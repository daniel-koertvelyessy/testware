<?php

    namespace App\Console\Commands;

    use App\User;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\Hash;


    class testwareDemoteUserSysAdminCommand extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'testware:demotesysadmin {user : E-Mail address of a registered user who\'s account will be stripped of SysAdmin status}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Demotes a given user to strip its SysAdmin status';

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
            $userEmail = $this->argument('user');
            $fetchUser = User::where('email', $userEmail);

            if ($fetchUser->count() === 0) {
                $this->newLine();
                $this->error('                                               ');
                $this->error('     User with given E-Mail not found!         ');
                $this->error('                                               ');
                $this->newLine();
                return 1;
            } else {
                $this->info('Demoting user : ' . $userEmail);
                $user = $fetchUser->first();
                $user->role_id = 0;
                if ($user->save()) {

                    $this->info('User was demoted successfully');
                    $this->newLine();
                    return 0;

                }


            }

            return 0;
        }


    }

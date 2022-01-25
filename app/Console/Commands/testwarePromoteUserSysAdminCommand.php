<?php

    namespace App\Console\Commands;

    use App\User;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\Hash;


    class testwarePromoteUserSysAdminCommand extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'testware:promotesysadmin {user : E-Mail address of a registered user who will be promoted to SysAdmin}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Promotes a given user to become SysAdmin';

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
                $this->info('Promoting user : ' . $userEmail);
                $user = $fetchUser->first();
                $user->role_id = 1;
                if ($user->save()) {

                    $this->info('User is promoted to SysAdmin');
                    $this->newLine();
                    return 0;

                }


            }

            return 0;
        }

    }

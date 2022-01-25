<?php

    namespace App\Console\Commands;

    use App\User;
    use Illuminate\Console\Command;
    use Illuminate\Support\Facades\Hash;


    class testwareResetUserPasswordCommand extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'testware:resetuserpw {user : E-Mail address of a registered user who\'s account password is to be reseted.}';

        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Reset the password of a given user e-mail';

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
                $this->info('Reseting password for user : ' . $userEmail);
                $user = $fetchUser->first();

                $NewPassword = $this->secret('Provide new password (min. 8 charakters)');
                $confirm_password = $this->secret('Confirm password');

                while (!$this->isValidPassword($NewPassword, $confirm_password)) {
                    if (!$this->isRequiredLength($NewPassword)) {
                        $this->error('Password must be more that six characters');
                    }

                    if (!$this->isMatch($NewPassword, $confirm_password)) {
                        $this->error('Password and Confirm password do not match');
                    }

                    $NewPassword = $this->secret('Password');
                    $confirm_password = $this->secret('Confirm password');
                }


                $user->password = Hash::make($NewPassword);
                if ($user->save()) {

                    $this->info('A new password has been set');
                    $this->newLine();
                    return 0;
                }


            }


            $output = '';


            return 0;
        }

        /**
         * Check if password is vailid
         *
         * @param string $password
         * @param string $confirmPassword
         *
         * @return boolean
         */
        private function isValidPassword(string $password, string $confirmPassword): bool
        {
            return $this->isRequiredLength($password) && $this->isMatch($password, $confirmPassword);
        }

        /**
         * Checks if password is longer than six characters.
         *
         * @param string $password
         *
         * @return bool
         */
        private function isRequiredLength(string $password): bool
        {
            return strlen($password) > 8;
        }

        /**
         * Check if password and confirm password matches.
         *
         * @param string $password
         * @param string $confirmPassword
         *
         * @return bool
         */
        private function isMatch(string $password, string $confirmPassword): bool
        {
            return $password === $confirmPassword;
        }

    }

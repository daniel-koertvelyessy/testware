<?php

namespace App\Console\Commands;

use App\Firma;
use App\Profile;
use Artisan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestwareInstallAppCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'testware:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with default data and create an initial user';

    private $user;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('* * * * * * * * * * * *   W A R N I N G   * * * * * * * * * * * ');
        $this->info('* ');
        $this->info('*          This installer will reset your database! ');
        $this->info('*       All data will be lost and cannot be restored!');
        $this->info('* ');
        $this->info('* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *');

        $this->info(' ');

        if ($this->confirm('Type [yes] to proceed or [no] to exit without changes.', false)) {
            $output = '';
            $this->info('* * * * *  Initialise database');
            if ($this->confirm('Fill database with default entries [yes] or leave it empty [no] ?', true)) {
                Artisan::call('migrate:fresh --seed', [], $output);
            } else {
                Artisan::call('migrate:fresh');
            }
            $this->info('Start working ... ');
            $this->info(Artisan::output());

            if ($this->confirm('Create new user with SuperAdmin privileges?', true)) {
                $details = $this->getDetails();
                $userID = $this->user->addInstallerUser($details);
                $this->info('* * * * *  New user created');
                if ($userID) {

                    /**
                     *   Reports require an userID therefore we can only seed them once the user is created
                     */
                    $this->seedReports($userID);

                    if ($this->confirm('Is this user going to be an employee as well?', false)) {
                        $this->registerEmpoyee($details['name'],$userID, $details['email']);
                    }

                }
            }

            $this->info('Generate new encryption key ...');
            Artisan::call('key:generate');

            $this->newLine(2);

            $this->info('Please use the newly created user to login at ' . env('APP_URL') . ':' . env('APP_PORT') . '/installer to set your company, location and complete the setup process.');

        }

        return 0;


    }

    /**
     *  Use the UserID and Name to create an employee
     *  At one employee is required to manage a location
     *  This step is optional as the employeed can be
     *  created later in the fornt-end installer as well
     *
     * @param $fullname
     * @param $userID
     * @param null $email
     * @return void
     */
    private function registerEmpoyee($fullname,$userID, $email=NULL): void
    {
        $names = explode(' ', $fullname);
        $employee = new Profile();
        $employee->user_id = $userID;
        $employee->ma_name = $this->ask('Name', $names[1]);
        if ($this->confirm('Continue with 6 optional fields as well?', true)) {
            $employee->ma_vorname = $this->ask('Surename ', $names[0]);
            $employee->ma_geburtsdatum = $this->ask('Birthday (YYYY-MM-DD)');
            $employee->ma_nummer = $this->ask('Employee ID ');
            $employee->ma_eingetreten = $this->ask('Employed on (YYYY-MM-DD)');
            $employee->ma_telefon = $this->ask('Phone-#');
            $employee->ma_mobil = $this->ask('Mobile-#');
            $employee->ma_email = $this->ask('E-Mail', $email);
        }
        $employee->save();
    }

    /**
     * Ask for admin details.
     *
     * @return array
     */
    private function getDetails()
    : array
    {

        $details['email'] = $this->ask('E-Mail (used for login)');

        while(!$this->confirm('Confirm given e-mail address : ' . utf8_encode($details['email']),false)){
            $details['email'] = $this->ask('E-Mail (used for login)');
        }


        while (User::where('email', $details['email'])->count() > 0) {
            $this->error('This e-mail address is already in use! Please us anotherone');
            $details['email'] = $this->ask('E-Mail (used for login)');
        }

        $details['username'] = $this->ask('Username (will be displayed in app)');
        while (User::where('username', $details['username'])->count() > 0) {
            $this->error('This username address is already in use! Please us anotherone');
            $details['username'] = $this->ask('Username');
        }

        $details['role_id'] = 1;
        $details['user_theme'] = 'css/tbs.css';
        $details['name'] = $this->ask('Name');
        $details['locales'] = $this->ask('Language', 'de');
        $details['password'] = $this->secret('Password (min. 8 charakters)');
        $details['confirm_password'] = $this->secret('Confirm password');

        while (!$this->isValidPassword($details['password'], $details['confirm_password'])) {
            if (!$this->isRequiredLength($details['password'])) {
                $this->error('Password must be more that six characters');
            }

            if (!$this->isMatch($details['password'], $details['confirm_password'])) {
                $this->error('Password and Confirm password do not match');
            }

            $details['password'] = $this->secret('Password');
            $details['confirm_password'] = $this->secret('Confirm password');
        }

        return $details;
    }

    /**
     * Check if password is vailid
     *
     * @param  string $password
     * @param  string $confirmPassword
     *
     * @return boolean
     */
    private function isValidPassword(string $password, string $confirmPassword)
    : bool
    {
        return $this->isRequiredLength($password) && $this->isMatch($password, $confirmPassword);
    }

    /**
     * Checks if password is longer than six characters.
     *
     * @param  string $password
     *
     * @return bool
     */
    private function isRequiredLength(string $password)
    : bool
    {
        return strlen($password) > 8;
    }

    /**
     * Check if password and confirm password matches.
     *
     * @param  string $password
     * @param  string $confirmPassword
     *
     * @return bool
     */
    private function isMatch(string $password, string $confirmPassword)
    : bool
    {
        return $password === $confirmPassword;
    }

    /**
     *  if a new user is generated two default reports
     *  will be seeded.
     *  The new user ID is needed for this
     */
    private function seedReports($userID)
    {
        DB::table('reports')->insert([
            [
                'created_at'     => now(),
                'updated_at'     => now(),
                'label'          => 'Standorte',
                'name'           => 'Standortbericht Allgemein',
                'description'    => 'Erstellt eine Übersicht aller Standorte mit entsprechender Struktur',
                'view'           => 'locations',
                'report_type_id' => '1',
                'user_id'        => $userID,
            ],
            [
                'created_at'     => now(),
                'updated_at'     => now(),
                'label'          => 'Inventurbericht',
                'name'           => 'Inventurliste',
                'description'    => 'Listet alle Geräte mit Status, Wert und dessen Abschreibung',
                'view'           => 'inventur',
                'report_type_id' => '1',
                'user_id'        => $userID,
            ],
        ]);
    }

}

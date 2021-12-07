<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class Admin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:user-create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new User';

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

        $name = $this->ask(__('What is your name?'));
        $email = $this->ask('What is your email?');
        $password = $this->secret('What is your password?');
        $birthDate = $this->ask('What is your birth date?');
        $gender = $this->choice(
            'What is your gender?',
            ['0', '1'],
        );
        $role = $this->choice(
            'What is your role?',
            ['User', 'Admin', 'Editor'],
        );

        $hasErrors = false;

        if (empty($name)) {
            $this->error('The name is required!');
            $hasErrors = true;
        }

        if (empty($email)) {
            $this->error('The email is required!');
            $hasErrors = true;
        } else {
            if (User::where('email', $email)->first()) {
                $this->error('The email was be taken!');
                $hasErrors = true;
            }
        }

        if (empty($password)) {
            $this->error('The password is required!');
            $hasErrors = true;
        }

        try {
            Carbon::parse($birthDate);
        } catch (\Exception $exception) {
            $this->error('Create user failed!:birthDate format error ');
        }

        if (!$hasErrors) {
            try {
                $isCreated = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make($password),
                    'birth_date' => Carbon::parse($birthDate),
                    'gender' => $gender,
                    'role' => $role
                ]);


                if ($isCreated) {
                    $this->info('Created a new user successfully!');
                }
            } catch (QueryException $exception) {
                $this->error('Create user failed!: Database Query Error');
            } catch (\Exception $exception) {
                $this->error('Create user failed!: ' . $exception->getMessage());
            }
        }
    }
}

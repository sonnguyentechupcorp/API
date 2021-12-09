<?php

namespace Tests\Console;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CommandTest extends TestCase

{
    public function createUser()
    {
        return User::create([
            'name' => 'son',
            'email' => 'son2',
            'password' => Hash::make('123456'),
            'birth_date' => Carbon::parse('1998-10-10'),
            'gender' => 1,
            'role' => ["User"],
        ]);
    }

    public function test_admin_command_exit_code_success()
    {
        $this->artisan('inspire')->assertSuccessful();
    }

    public function test_import_admin_command_failed()
    {
        $user = $this->createUser();

        $this->artisan('demo:user-create')
            ->expectsQuestion('What is your name?', '')
            ->expectsQuestion('What is your email?', 'asdasd')
            ->expectsQuestion('What is your password?', '123456')
            ->expectsQuestion('What is your birth date?', '')
            ->expectsQuestion('What is your gender?', '')
            ->expectsQuestion('What is your role?', '')
            ->expectsOutput('The name is required!')
            ->assertExitCode(0);

        $this->artisan('demo:user-create')
            ->expectsQuestion('What is your name?', 'sadasd')
            ->expectsQuestion('What is your email?', '')
            ->expectsQuestion('What is your password?', '123')
            ->expectsQuestion('What is your birth date?', '')
            ->expectsQuestion('What is your gender?', '')
            ->expectsQuestion('What is your role?', '')
            ->expectsOutput('The email is required!')
            ->assertExitCode(0);

        $this->artisan('demo:user-create')
            ->expectsQuestion('What is your name?', 'asdsad')
            ->expectsQuestion('What is your email?', 'sd')
            ->expectsQuestion('What is your password?', '')
            ->expectsQuestion('What is your birth date?', '')
            ->expectsQuestion('What is your gender?', '')
            ->expectsQuestion('What is your role?', '')
            ->expectsOutput('The password is required!')
            ->assertExitCode(0);

        $this->artisan('demo:user-create')
            ->expectsQuestion('What is your name?', '')
            ->expectsQuestion('What is your email?', '')
            ->expectsQuestion('What is your password?', '')
            ->expectsQuestion('What is your birth date?', '')
            ->expectsQuestion('What is your gender?', '')
            ->expectsQuestion('What is your role?', '')
            ->expectsOutput('The name is required!')
            ->expectsOutput('The email is required!')
            ->expectsOutput('The password is required!')
            ->assertExitCode(0);

        $this->artisan('demo:user-create')
            ->expectsQuestion('What is your name?', 'son2')
            ->expectsQuestion('What is your email?', 'son2')
            ->expectsQuestion('What is your password?', '123')
            ->expectsQuestion('What is your birth date?', '')
            ->expectsQuestion('What is your gender?', '')
            ->expectsQuestion('What is your role?', '')
            ->expectsOutput('The email was be taken!')
            ->assertExitCode(0);
    }
}

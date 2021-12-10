<?php

namespace App\Console\Commands;

use Mail;
use App\Mail\SendTotalNewUserTodayToAdmin;
use App\Models\User;
use Illuminate\Console\Command;

class SendReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:send-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send mail total new user today to the admin.
    ';

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

        $date = date('Y-m-d');

        $user = User::whereDate('created_at', '=', $date )->count();

        Mail::to('admin@gmail.com')->send(new SendTotalNewUserTodayToAdmin($user));

        $this->info('The emails are send successfully!');
    }
}

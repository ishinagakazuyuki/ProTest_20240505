<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Batch;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendRemindMail;
use App\Models\User;
use App\Models\shop;
use App\Models\reservation;

class SendReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:send_mail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminder emails to user';

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
        $date = date('Y/m/d');
        $user = user::join('reservations','users.id','reservations.user_id')->where('date','=',$date)->get();
        foreach ($user as $users) {
            $shop = shop::join('reservations','shops.id','reservations.shops_id')->where('date','=',$date)->where('reservations.id','=',$users['id'])->get();
            foreach ($shop as $shops) {
                Mail::to($users->email)->send(new SendRemindMail($users,$shops));
            }
        }
    }
}

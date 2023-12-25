<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRemindMail extends Mailable
{
    use Queueable, SerializesModels;

    public $users;
    public $shops;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($users,$shops)
    {
        $this->users = $users;
        $this->shops = $shops;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "【ご予約日のお知らせ】{$this->shops->name}";
        return $this->view('emails.remind')
                    ->subject($subject);
    }
}

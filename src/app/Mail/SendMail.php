<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $shop;
    public $date;
    public $time;
    public $number;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$shop,$date,$time,$number)
    {
        $this->name = $name;
        $this->shop = $shop;
        $this->date = $date;
        $this->time = $time;
        $this->number = $number;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = "【ご予約日のお知らせ】{$this->shop}";
        return $this->view('emails.sendmail')
            ->subject($subject);
    }
}

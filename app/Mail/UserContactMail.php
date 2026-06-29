<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserContactMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $full_name;

    public function __construct($full_name)
    {
        $this->full_name = $full_name;
    }

    public function build()
    {
        return $this->subject('[MINTOKU.VN] - Xác nhận tiếp nhận thông tin - Mintoku Work')
                    ->view('emails.user_contact_template');
    }
}
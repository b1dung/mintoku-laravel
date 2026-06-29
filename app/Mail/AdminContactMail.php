<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminContactMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this->subject('[MINTOKU.VN][YÊU CẦU LIÊN HỆ] ' . $this->data['info']['full_name'])
                    ->view('emails.admin_contact_template')
                    ->with([
                        'info' => $this->data['info'],
                        'subject_label' => $this->data['subject_label'],
                    ]);
    }
}
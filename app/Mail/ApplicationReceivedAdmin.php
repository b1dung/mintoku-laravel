<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationReceivedAdmin extends Mailable
{
    use Queueable, SerializesModels;

    // 1. Define public variables to pass to the view
    public $application;
    public $user;

    /**
     * 2. Accept the data in the constructor
     */
    public function __construct($application, $user)
    {
        $this->application = $application;
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            // Updated to English as requested
            subject: 'New Job Application Received - Job #' . $this->application->job_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_notification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
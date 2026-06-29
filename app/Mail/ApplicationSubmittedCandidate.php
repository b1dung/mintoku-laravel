<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationSubmittedCandidate extends Mailable
{
    use Queueable, SerializesModels;

    // 1. Define public properties (They will be visible in the Blade view)
    public $application;
    public $user;

    /**
     * 2. Accept variables in the constructor
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
            subject: 'Application Successfully Submitted - Job #' . $this->application->job_id,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.candidate_applied',
            // You can also use 'with' but public properties are simpler
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewJobApplicationNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $application;

    /**
     * Create a new message instance.
     */
    public function __construct($application)
    {
        $this->application = $application;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Job Application Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.job.new',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];

        if ($this->application->resume_path) {
            $resumePath = storage_path('app/public/' . $this->application->resume_path);
            if (file_exists($resumePath)) {
                $attachments[] = Attachment::fromPath($resumePath);
            }
        }

        if ($this->application->portfolio_path) {
            $portfolioPath = storage_path('app/public/' . $this->application->portfolio_path);
            if (file_exists($portfolioPath)) {
                $attachments[] = Attachment::fromPath($portfolioPath);
            }
        }

        return $attachments;
    }
}

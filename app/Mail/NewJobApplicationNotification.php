<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewJobApplicationNotification extends Mailable
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

        $disk = config('filesystems.default');

        if ($this->application->resume_path && \Illuminate\Support\Facades\Storage::disk($disk)->exists($this->application->resume_path)) {
            $attachments[] = Attachment::fromStorageDisk($disk, $this->application->resume_path);
        }

        if ($this->application->portfolio_path && \Illuminate\Support\Facades\Storage::disk($disk)->exists($this->application->portfolio_path)) {
            $attachments[] = Attachment::fromStorageDisk($disk, $this->application->portfolio_path);
        }

        return $attachments;
    }
}

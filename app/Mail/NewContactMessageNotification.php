<?php

namespace App\Mail;

use App\Mail\Concerns\AttachesSubmissionFiles;
use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewContactMessageNotification extends Mailable implements ShouldQueue
{
    use AttachesSubmissionFiles, Queueable, SerializesModels;

    public function __construct(public ContactMessage $messageData)
    {
    }

    public function envelope(): Envelope
    {
        // Replying from the inbox goes straight to the person who wrote in.
        return new Envelope(
            replyTo: [new Address($this->messageData->email, $this->messageData->name)],
            subject: 'New message: '.$this->messageData->subject,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.contact.new',
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return $this->submissionAttachments($this->messageData->attachmentList());
    }
}

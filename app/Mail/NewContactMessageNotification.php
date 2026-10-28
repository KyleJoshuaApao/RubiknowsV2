<?php

namespace App\Mail;

use App\Mail\Concerns\AttachesSubmissionFiles;
use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
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
        return new Envelope(
            subject: 'New Contact Message Notification',
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

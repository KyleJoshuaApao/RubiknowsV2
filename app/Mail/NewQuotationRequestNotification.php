<?php

namespace App\Mail;

use App\Mail\Concerns\AttachesSubmissionFiles;
use App\Models\QuotationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewQuotationRequestNotification extends Mailable implements ShouldQueue
{
    use AttachesSubmissionFiles, Queueable, SerializesModels;

    public function __construct(public QuotationRequest $quotation)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Quotation Request Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.quotation.new',
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return $this->submissionAttachments($this->quotation->attachmentList());
    }
}

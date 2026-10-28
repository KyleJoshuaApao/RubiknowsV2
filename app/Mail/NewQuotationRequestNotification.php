<?php

namespace App\Mail;

use App\Mail\Concerns\AttachesSubmissionFiles;
use App\Models\QuotationRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
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
            replyTo: [new Address($this->quotation->email, $this->quotation->name)],
            subject: 'New quotation request: '.$this->quotation->service_needed.' ('.$this->quotation->project_location.')',
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

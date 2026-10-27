<?php

namespace App\Mail\Transport;

use Illuminate\Support\Facades\Http;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\MessageConverter;

/**
 * Sends mail through Resend's HTTPS API. Render's free instances cannot open
 * SMTP connections, so every outgoing email uses this transport in production.
 */
class ResendApiTransport extends AbstractTransport
{
    public function __construct(private readonly string $apiKey)
    {
        parent::__construct();
    }

    protected function doSend(SentMessage $message): void
    {
        if (trim($this->apiKey) === '') {
            throw new \RuntimeException('Email delivery requires RESEND_API_KEY to be configured.');
        }

        $email = MessageConverter::toEmail($message->getOriginalMessage());
        $format = fn (array $addresses): array => array_map(fn (Address $address) => $address->toString(), $addresses);

        $payload = array_filter([
            'from' => $format($email->getFrom())[0] ?? $message->getEnvelope()->getSender()->toString(),
            'to' => $format($email->getTo()),
            'cc' => $format($email->getCc()),
            'bcc' => $format($email->getBcc()),
            'reply_to' => $format($email->getReplyTo()),
            'subject' => (string) $email->getSubject(),
            'html' => $email->getHtmlBody(),
            'text' => $email->getTextBody(),
            'attachments' => array_map(fn ($attachment) => [
                'filename' => $attachment->getFilename() ?? 'attachment',
                'content' => base64_encode($attachment->getBody()),
            ], $email->getAttachments()),
        ], fn ($value) => $value !== null && $value !== [] && $value !== '');

        $response = Http::acceptJson()
            ->withToken($this->apiKey)
            ->withHeaders(['User-Agent' => 'RubiKnows/1.0'])
            ->timeout(15)
            ->post('https://api.resend.com/emails', $payload)
            ->throw();

        if ($id = $response->json('id')) {
            $message->setMessageId((string) $id);
        }
    }

    public function __toString(): string
    {
        return 'resend+api://api.resend.com';
    }
}

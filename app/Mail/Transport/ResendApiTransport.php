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
            'from' => self::sender($email->getFrom()[0] ?? $message->getEnvelope()->getSender()),
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

    /**
     * Resend only sends from domains verified in the account. Free mailbox
     * domains can never be verified, so mail from them goes out through
     * Resend's shared sender while keeping the display name.
     */
    public static function sender(Address $from): string
    {
        $domain = strtolower(substr(strrchr($from->getAddress(), '@') ?: '', 1));
        $freeMailDomains = ['gmail.com', 'googlemail.com', 'yahoo.com', 'outlook.com', 'hotmail.com', 'live.com', 'icloud.com', 'ymail.com'];

        if ($domain === '' || in_array($domain, $freeMailDomains, true)) {
            return (new Address('onboarding@resend.dev', $from->getName() ?: (string) config('mail.from.name')))->toString();
        }

        return $from->toString();
    }

    public function __toString(): string
    {
        return 'resend+api://api.resend.com';
    }
}

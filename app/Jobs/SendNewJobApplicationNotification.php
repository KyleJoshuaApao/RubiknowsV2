<?php

namespace App\Jobs;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class SendNewJobApplicationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The queue worker retries transient HTTPS provider failures. Resend's
     * idempotency key below prevents a retry from sending duplicates.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * @var array<int, int>
     */
    public $backoff = [60, 300, 900];

    public function __construct(
        public int $applicationId,
        public string $recipient,
    ) {
    }

    public function handle(): void
    {
        $apiKey = config('services.resend.key');

        if (!is_string($apiKey) || trim($apiKey) === '') {
            throw new RuntimeException('Job application email delivery requires RESEND_API_KEY to be configured.');
        }

        if (!filter_var($this->recipient, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Job application email delivery requires a valid company notification email.');
        }

        $application = JobApplication::query()
            ->with('job')
            ->findOrFail($this->applicationId);

        $fromAddress = (string) config('mail.from.address');
        if (!filter_var($fromAddress, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('Job application email delivery requires a valid MAIL_FROM_ADDRESS.');
        }

        $fromName = trim((string) config('mail.from.name'));
        $from = $fromName === '' ? $fromAddress : "{$fromName} <{$fromAddress}>";

        $payload = [
            'from' => $from,
            'to' => [$this->recipient],
            'subject' => 'New Job Application Notification',
            'html' => view('emails.job.new', compact('application'))->render(),
        ];

        $attachments = $this->attachmentsFor($application);
        if ($attachments !== []) {
            $payload['attachments'] = $attachments;
        }

        Http::acceptJson()
            ->withToken($apiKey)
            ->withHeaders([
                'User-Agent' => 'RubiKnows/1.0',
                'Idempotency-Key' => "job-application-{$application->id}",
            ])
            ->timeout(15)
            ->post('https://api.resend.com/emails', $payload)
            ->throw();
    }

    /**
     * @return array<int, array{filename: string, content: string}>
     */
    private function attachmentsFor(JobApplication $application): array
    {
        $disk = Storage::disk(JobApplication::UPLOAD_DISK);
        $attachments = [];

        foreach (array_filter([$application->resume_path, $application->portfolio_path]) as $path) {
            if (!$disk->exists($path)) {
                continue;
            }

            $contents = $disk->get($path);
            if (!is_string($contents)) {
                throw new RuntimeException("Unable to read application attachment: {$path}");
            }

            $attachments[] = [
                'filename' => basename($path),
                'content' => base64_encode($contents),
            ];
        }

        return $attachments;
    }
}

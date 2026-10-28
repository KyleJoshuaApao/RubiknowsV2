<?php

namespace App\Mail\Concerns;

use Illuminate\Mail\Mailables\Attachment;

/**
 * Attach the files sent with a message or quotation, as long as they fit
 * comfortably in one email. Larger sets are downloaded from the admin panel.
 */
trait AttachesSubmissionFiles
{
    private const EMAIL_ATTACHMENT_LIMIT = 15 * 1024 * 1024;

    /**
     * @param  array<int, array{path: string, name: string, size: int|null, disk: string|null}>  $files
     * @return array<int, Attachment>
     */
    protected function submissionAttachments(array $files): array
    {
        $files = array_values(array_filter($files, fn (array $file) => $file['disk'] !== null));

        if (array_sum(array_map(fn (array $file) => (int) $file['size'], $files)) > self::EMAIL_ATTACHMENT_LIMIT) {
            return [];
        }

        return array_map(
            fn (array $file) => Attachment::fromStorageDisk($file['disk'], $file['path'])->as($file['name']),
            $files
        );
    }
}

<?php

namespace App\Models\Concerns;

use App\Support\SubmissionFiles;
use Illuminate\Support\Facades\Storage;

/**
 * Files sent with a public submission. Older quotation requests kept a single
 * file in attachment_path; it is listed first so nothing goes missing.
 */
trait HasAttachments
{
    /**
     * @return array<int, array{path: string, name: string, size: int|null, disk: string|null}>
     */
    public function attachmentList(): array
    {
        $files = [];

        if ($this->attachment_path) {
            $files[] = ['path' => $this->attachment_path, 'name' => basename($this->attachment_path), 'size' => null];
        }

        foreach ((array) ($this->attachments ?? []) as $file) {
            if (is_array($file) && filled($file['path'] ?? null)) {
                $files[] = ['path' => $file['path'], 'name' => $file['name'] ?? basename($file['path']), 'size' => $file['size'] ?? null];
            }
        }

        return array_map(fn (array $file) => [...$file, 'disk' => $this->diskHolding($file['path'])], $files);
    }

    /**
     * Older files may still sit on the local private disk or the default disk.
     */
    private function diskHolding(string $path): ?string
    {
        foreach (array_unique([SubmissionFiles::DISK, 'local', config('filesystems.default')]) as $disk) {
            try {
                if (Storage::disk($disk)->exists($path)) {
                    return $disk;
                }
            } catch (\Throwable) {
                continue;
            }
        }

        return null;
    }

    public function deleteAttachments(): void
    {
        foreach ($this->attachmentList() as $file) {
            if ($file['disk']) {
                Storage::disk($file['disk'])->delete($file['path']);
            }
        }
    }
}

<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    public const PUBLIC_UPLOAD_DISK = 'media';

    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'pdf', 'doc', 'docx', 'mp4', 'mov', 'zip'];

    /**
     * Upload a file and return the stored path.
     *
     * @param UploadedFile|null $file
     * @param string $directory
     * @param string|null $oldFilePath
     * @return string|null
     */
    public function upload(?UploadedFile $file, string $directory = 'uploads', ?string $oldFilePath = null, string $disk = self::PUBLIC_UPLOAD_DISK): ?string
    {
        if (!$file) {
            return $oldFilePath;
        }

        // Generate a short, safe filename using UUID + actual extension (not what the client claims)
        $extension = strtolower($file->extension()) ?: 'jpg';

        // Security: strict ALLOWLIST — only permitted types can be uploaded
        if (! in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new \Exception("File upload failed: File type '{$extension}' is not permitted.");
        }

        $filename = Str::uuid().'.'.$extension;

        try {
            $path = $file->storeAs($directory, $filename, $disk);
        } catch (\Throwable $exception) {
            throw new \RuntimeException('The uploaded file could not be stored.', 0, $exception);
        }

        if (!is_string($path) || $path === '') {
            throw new \RuntimeException('The uploaded file could not be stored.');
        }

        // Keep the old file until the replacement has been safely persisted.
        if ($oldFilePath) {
            $this->delete($oldFilePath, $disk);
        }

        return $path;
    }

    /**
     * Delete a file from storage.
     *
     * @param string|null $filePath
     * @return void
     */
    public function delete(?string $filePath, string $disk = self::PUBLIC_UPLOAD_DISK): void
    {
        // Remote URLs and files shipped in public/ are not ours to delete.
        if (! $filePath || filter_var($filePath, FILTER_VALIDATE_URL) || str_starts_with($filePath, '/')) {
            return;
        }

        try {
            if (Storage::disk($disk)->exists($filePath)) {
                Storage::disk($disk)->delete($filePath);
            }
        } catch (\Throwable $exception) {
            // Cleaning up a file must never block deleting or updating the record.
            report($exception);
        }
    }
}

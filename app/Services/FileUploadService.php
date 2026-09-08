<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload a file and return the stored path.
     *
     * @param UploadedFile|null $file
     * @param string $directory
     * @param string|null $oldFilePath
     * @return string|null
     */
    public function upload(?UploadedFile $file, string $directory = 'uploads', ?string $oldFilePath = null): ?string
    {
        if (!$file) {
            return $oldFilePath;
        }

        // Delete the old file if it exists
        if ($oldFilePath) {
            $this->delete($oldFilePath);
        }

        // Generate a short, safe filename using UUID + actual extension (not what the client claims)
        $extension = strtolower($file->extension()) ?: 'jpg';
        
        // Security: strict ALLOWLIST — only permitted types can be uploaded
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'pdf', 'doc', 'docx', 'mp4', 'mov', 'zip'];
        if (!in_array($extension, $allowedExtensions)) {
            throw new \Exception("File upload failed: File type '{$extension}' is not permitted.");
        }

        $filename  = (string) \Illuminate\Support\Str::uuid() . '.' . $extension;

        // Store the file and return its path
        $disk = config('filesystems.default');
        return $file->storeAs($directory, $filename, $disk);
    }

    /**
     * Delete a file from storage.
     *
     * @param string|null $filePath
     * @return void
     */
    public function delete(?string $filePath): void
    {
        $disk = config('filesystems.default');
        if ($filePath && Storage::disk($disk)->exists($filePath)) {
            Storage::disk($disk)->delete($filePath);
        }
    }
}

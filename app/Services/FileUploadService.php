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

        // Generate a clean filename
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '-' . time() . '.' . $file->getClientOriginalExtension();

        // Store the file and return its path
        return $file->storeAs($directory, $filename, 'public');
    }

    /**
     * Delete a file from storage.
     *
     * @param string|null $filePath
     * @return void
     */
    public function delete(?string $filePath): void
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}

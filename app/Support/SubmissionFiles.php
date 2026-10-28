<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Optional files sent with a message or quotation request: plans, photos,
 * documents, spreadsheets, CAD drawings and archives. Stored privately.
 */
final class SubmissionFiles
{
    public const DISK = 'documents';

    public const MAX_FILES = 5;

    public const MAX_KILOBYTES = 15360;

    public const EXTENSIONS = [
        'jpg', 'jpeg', 'png', 'webp', 'gif', 'heic', 'heif',
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'csv', 'rtf',
        'dwg', 'dxf', 'skp',
        'zip', 'rar', '7z',
    ];

    /** Value for the file input's accept attribute. */
    public static function accept(): string
    {
        return implode(',', array_map(fn (string $extension) => '.'.$extension, self::EXTENSIONS));
    }

    /**
     * @return array<string, array<int, string>>
     */
    public static function rules(): array
    {
        return [
            'attachments' => ['nullable', 'array', 'max:'.self::MAX_FILES],
            'attachments.*' => ['file', 'max:'.self::MAX_KILOBYTES, 'extensions:'.implode(',', self::EXTENSIONS)],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function messages(): array
    {
        return [
            'attachments.max' => 'You can attach up to '.self::MAX_FILES.' files.',
            'attachments.*.max' => 'Each file must be 15 MB or smaller.',
            'attachments.*.extensions' => 'Please attach photos, PDF, Word, Excel, CAD drawings or ZIP files.',
            'attachments.*.file' => 'One of the files could not be uploaded. Please try again.',
        ];
    }

    /**
     * Store the uploaded files. If any file fails, the ones already stored are removed.
     *
     * @param  array<int, UploadedFile>  $files
     * @return array<int, array{path: string, name: string, size: int}>
     */
    public static function store(array $files, string $directory): array
    {
        $stored = [];

        try {
            foreach ($files as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                $path = $file->storeAs($directory, Str::uuid().'.'.$extension, self::DISK);

                if (! $path) {
                    throw new \RuntimeException('An attachment could not be stored.');
                }

                $stored[] = [
                    'path' => $path,
                    'name' => Str::limit(basename($file->getClientOriginalName()), 120, ''),
                    'size' => (int) $file->getSize(),
                ];
            }
        } catch (\Throwable $exception) {
            self::delete($stored);

            throw $exception;
        }

        return $stored;
    }

    /**
     * @param  array<int, array{path: string}>  $attachments
     */
    public static function delete(array $attachments): void
    {
        $paths = array_values(array_filter(array_column($attachments, 'path')));

        if ($paths !== []) {
            Storage::disk(self::DISK)->delete($paths);
        }
    }
}

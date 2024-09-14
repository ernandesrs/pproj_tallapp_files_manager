<?php

namespace Ernandesrs\TallAppFilesManager\Services;

use Ernandesrs\TallAppFilesManager\Models\File;
use Illuminate\Http\UploadedFile;

class FileService
{
    /**
     * Register file
     * @param array $validated
     * @return null|\Ernandesrs\TallAppFilesManager\Models\File
     */
    static function create(array $validated): null|File
    {
        /**
         * @var UploadedFile $file
         */
        $file = $validated['file'];
        $originalName = $validated['original_name'];
        $tags = $validated['tags'] ?? [];

        $fileType = File::fileType($file->getClientOriginalExtension());
        $path = $file->storePublicly(\Str::plural($fileType), []);
        if (!$path) {
            return null;
        }

        return File::create([
            'name' => $file->getFilename(),
            'original_name' => !empty($originalName) ? $originalName : \Str::replace("." . $file->getClientOriginalExtension(), "", $file->getClientOriginalName()),
            'type' => $fileType,
            'path' => $path,
            'tags' => $tags,
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
        ]);
    }

    /**
     * Creation rules
     * @return array
     */
    static function createRules(): array
    {
        return [
            'file' => ['required', 'mimes:' . implode(',', File::allowedExtensions(merged: true))],
            'original_name' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['required', 'string', 'max:25']
        ];
    }
}

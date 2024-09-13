<?php

namespace Ernandesrs\TallAppFilesManager\Models;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * Fillables
     * @var array
     */
    protected $fillable = [
        'original_name',
        'name',
        'path',
        'tags',
        'extension',
        'type',
        'size'
    ];

    /**
     * Casts
     * @var array
     */
    protected $casts = [
        'type' => \Ernandesrs\TallAppFilesManager\Enums\FileTypesEnum::class,
        'tags' => 'array'
    ];

    /**
     * Allowed extensions
     * @param bool $merged
     * @return array|mixed
     */
    static function allowedExtensions(bool $merged = false)
    {
        $allowedExtensionsFromConfig = config('tallapp-files-manager.allowed_extensions');
        return $merged ? array_merge(...array_values($allowedExtensionsFromConfig)) : $allowedExtensionsFromConfig;
    }

    /**
     * Get file type by extension
     * @param string $extension
     * @return ?string
     */
    static function fileType(string $extension): ?string
    {
        $type = null;

        collect(self::allowedExtensions())->first(function ($extensions, $key) use ($extension, &$type) {
            $finded = collect($extensions)->first(function ($ext) use ($extension) {
                return $ext == $extension;
            });

            $type = $finded ? $key : null;

            return $finded;
        });

        return $type;
    }
}

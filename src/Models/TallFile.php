<?php

namespace Ernandesrs\TallAppFilesManager\Models;
use Illuminate\Database\Eloquent\Model;

class TallFile extends Model
{
    /**
     * Fillables
     * @var array
     */
    protected $fillable = [
        'name',
        'extension',
        'type',
        'size'
    ];

    /**
     * Casts
     * @var array
     */
    protected $casts = [
        'type' => \Ernandesrs\TallAppFilesManager\Enums\FileTypesEnum::class
    ];
}

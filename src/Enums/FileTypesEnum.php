<?php

namespace Ernandesrs\TallAppFilesManager\Enums;

enum FileTypesEnum: string
{
    case DOCUMENT = 'document';

    case VIDEO = 'video';

    case IMAGE = 'image';

    /**
     * Label
     * @return string
     */
    function label(): string
    {
        return match ($this) {
            self::DOCUMENT => __('tallapp-files-manager::file-types.document.single'),
            self::VIDEO => __('tallapp-files-manager::file-types.video.single'),
            self::IMAGE => __('tallapp-files-manager::file-types.image.single'),
        };
    }
}

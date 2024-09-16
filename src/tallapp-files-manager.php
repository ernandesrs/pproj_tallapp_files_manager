<?php

return [
    /**
     *
     * Allowed extensions
     *
     */
    'allowed_extensions' => [
        'image' => [
            'png',
            'jpg',
            'jpeg',
            'webp'
        ],
        'video' => [
            'mp4'
        ],
        'document' => [
            // document
            'pdf',
            'doc',
            'docx'
        ],
    ],

    /**
     *
     * Policy class containing this default Laravel Policy methods:
     * viewAny:
     * view:
     * create:
     * update:
     * delete:
     *
     */
    'policy' => null,
];

<?php

return [
    'upload' => [
        'url' => '/filament-unlayer-upload-action',
        'url_name' => 'filament-unlayer.upload',
        'class' => \InfinityXTech\FilamentUnlayer\Services\UploadImage::class,
        'disk' => 'public',
        'path' => 'unlayer',
        'validation' => 'required|image',
        'middlewares' => [],
    ],
];

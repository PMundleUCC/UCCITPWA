<?php

return [

    // The home page provides its own install button.

    'install-button' => false,

    // App details used to generate public/manifest.json.

    'manifest' => [
        'id' => '/',
        'scope' => '/',
        'name' => 'UCC IT Student Hub',
        'short_name' => 'UCC IT',
        'background_color' => '#f6f8f9',
        'display' => 'standalone',
        'description' => 'Your department, courses, and campus connections in one place.',
        'theme_color' => '#174b73',
        'icons' => [
            [
                'src' => '/images/ucc-student-hub-icon-512x512.png',
                'sizes' => '512x512',
                'type' => 'image/png',
            ],
            ['src' => '/images/ucc-student-hub-icon-192x192.png', 'sizes' => '192x192', 'type' => 'image/png', 'purpose' => 'any'],
            ['src' => '/images/ucc-student-hub-maskable-icon-512x512.png', 'sizes' => '512x512', 'type' => 'image/png', 'purpose' => 'maskable'],
        ],
    ],

    // Show service worker logs during development.

    'debug' => env('APP_DEBUG', false),

    // Enable only if the app uses Livewire.

    'livewire-app' => false,
];

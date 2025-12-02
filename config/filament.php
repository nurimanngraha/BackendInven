<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Broadcasting
    |--------------------------------------------------------------------------
    |
    | By uncommenting the Laravel Echo configuration, you may connect Filament
    | to any Pusher-compatible websockets server.
    |
    | This will allow your users to receive real-time notifications.
    |
    */

    'broadcasting' => [

        // 'echo' => [
        //     'broadcaster' => 'pusher',
        //     'key' => env('VITE_PUSHER_APP_KEY'),
        //     'cluster' => env('VITE_PUSHER_APP_CLUSTER'),
        //     'forceTLS' => true,
        // ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | This is the storage disk Filament will use to put media. You may use any
    | of the disks defined in the `config/filesystems.php`.
    |
    */

    'default_filesystem_disk' => env('FILAMENT_FILESYSTEM_DISK', 'public'),

    /*
    |--------------------------------------------------------------------------
    | Appearance
    |--------------------------------------------------------------------------
    |
    | Force Filament to always use light mode and disable theme switching.
    |
    */
    'assets' => [
    'css' => [
        'css/custom.css',
    ],
],

    'panel_providers' => [
    App\Providers\Filament\AdminPanelProvider::class,
],
    'auth' => [
    'guard' => 'web',
    'pages' => [
        'login' => \Filament\Pages\Auth\Login::class,
    ],
],

    'appearance' => [
        'theme' => 'light',
        'themes' => ['light'], // hanya tema terang yang diizinkan
    ],

];

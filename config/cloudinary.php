<?php

/*
 * This file is part of the Laravel Cloudinary package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Notification URL (optional)
    |--------------------------------------------------------------------------
    |
    | An HTTP or HTTPS URL to notify your application (a webhook) when
    | the process of uploads, deletes, and any API that accepts
    | notification_url has completed.
    |
    */
    'notification_url' => env('CLOUDINARY_NOTIFICATION_URL'),

    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | You may configure your Cloudinary settings here.
    | These settings will be used for all file uploads, storage,
    | delivery and transformation needs.
    |
    | Pastikan ENV berikut sudah diisi:
    | CLOUDINARY_CLOUD_NAME
    | CLOUDINARY_API_KEY
    | CLOUDINARY_API_SECRET
    |
    */
    'cloud' => [
        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
        'api_key'    => env('CLOUDINARY_API_KEY'),
        'api_secret' => env('CLOUDINARY_API_SECRET'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Secure URLs
    |--------------------------------------------------------------------------
    |
    | Whether to use https for assets
    |
    */
    'url' => [
        'secure' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Upload Preset (optional)
    |--------------------------------------------------------------------------
    |
    | Jika kamu menggunakan Upload Preset dari dashboard Cloudinary,
    | masukkan di sini.
    |
    */
    'upload_preset' => env('CLOUDINARY_UPLOAD_PRESET'),

    /*
    |--------------------------------------------------------------------------
    | Blade Upload Widget (optional)
    |--------------------------------------------------------------------------
    |
    | Untuk route atau action dari Blade upload widget.
    |
    */
    'upload_route'  => env('CLOUDINARY_UPLOAD_ROUTE'),
    'upload_action' => env('CLOUDINARY_UPLOAD_ACTION'),
];

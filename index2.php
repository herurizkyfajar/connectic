<?php
/**
 * Laravel Entry Point for app.rtikcmh.com
 * 
 * INSTRUCTIONS:
 * 1. Copy content file ini
 * 2. Paste ke: /home/wmsb4692/public_html/app.rtikcmh.com/index.php
 * 3. Replace semua content yang ada
 * 
 * STRUCTURE:
 * /home/wmsb4692/
 *   ├── simrtik/              ← Laravel app folder
 *   │   ├── app/
 *   │   ├── bootstrap/
 *   │   ├── vendor/
 *   │   └── .env
 *   └── public_html/
 *       └── app.rtikcmh.com/  ← Document root (this file is here)
 *           └── index.php     ← THIS FILE
 */

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'../bootstrap/app.php')
    ->handleRequest(Request::capture());



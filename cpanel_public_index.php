<?php
/**
 * Laravel Entry Point for cPanel Deployment
 * 
 * ⚠️ IMPORTANT: Copy this file to public_html/index.php
 * 
 * This file should be placed in your public_html folder
 * and the Laravel application should be in ../laravel/ folder
 * 
 * Structure:
 * /home/username/
 *   ├── public_html/
 *   │   └── index.php (this file)
 *   └── laravel/
 *       ├── app/
 *       ├── bootstrap/
 *       ├── vendor/
 *       └── ...
 */

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../laravel/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../laravel/vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../laravel/bootstrap/app.php')
    ->handleRequest(Request::capture());


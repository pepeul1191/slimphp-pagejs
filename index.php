<?php
if (PHP_SAPI == 'cli-server') {
  // To help the built-in PHP dev server, check if the request was actually for
  // something which should probably be served as a static file
  $url  = parse_url($_SERVER['REQUEST_URI']);
  $file = __DIR__ . $url['path'];
  if (is_file($file)) {
    return false;
  }
}

require __DIR__ . '/vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __DIR__ . '/application/configs/settings.php';
$app = new \Slim\App($settings);

// Register database
require __DIR__ . '/application/configs/database.php';
// Set up dependencies
require __DIR__ . '/application/configs/dependencies.php';
// Register middleware
require __DIR__ . '/application/configs/middleware.php';
// Register routes
require __DIR__ . '/application/configs/routes.php';

// Run app
$app->run();

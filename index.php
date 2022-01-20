<?php

if (isset($_SERVER['HTTPS']) &&
  ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
  isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
  $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $protocol = 'https://'; // cambiar cuando haya SSL
  //$protocol = 'http://';
}
else {
  $protocol = 'http://';
}

if($protocol == 'http://'){
  $url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
  $url = explode(".", $escaped_url);
  $www_removed = false;
  if($url[0] == 'www'){
      unset($url[0]);
      $escaped_url = implode(".", $url);
      $www_removed = true;
  }
  //echo $www_removed;  echo $escaped_url;  exit();
  if($www_removed){
      header( "Location: https://" . $escaped_url );
  }else{
      header( "Location: https://" . $url );
  }
}else{
  $url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
  $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
  $url = explode(".", $escaped_url);
  $www_removed = false;
  if(strcasecmp($url[0], "www") == 0){
      unset($url[0]);
      $escaped_url = implode(".", $url);
      $www_removed = true;
  }
  if($www_removed){
      header( "Location: https://" . $escaped_url );
  }
}

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
$settings = require __DIR__ . '/src/configs/settings.php';
$app = new \Slim\App($settings);

// Register database
require __DIR__ . '/src/configs/database.php';
// Set up dependencies
require __DIR__ . '/src/configs/dependencies.php';
// Register middleware
require __DIR__ . '/src/configs/middleware.php';
// Register routes
require __DIR__ . '/src/configs/routes.php';

// Run app
$app->run();

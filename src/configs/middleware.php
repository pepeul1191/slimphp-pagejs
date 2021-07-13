<?php
// Application middleware

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$env = $dotenv->load();

// e.g: $app->add(new \Slim\Csrf\Guard);
$mw_ambiente_csrf = function ($request, $response, $next) {
  $settings = require 'settings.php';
  $continuar = true;
  $env = $_ENV['ENV'];
  if($settings['settings']['constants'][$env]['validation_csrf'] == 'able'){
    if($request->getHeader($settings['settings']['constants']['csrf']['key'])[0] != $settings['settings']['constants']['csrf']['secret']){
      $continuar = false;
    }
  }
  if($continuar == true){
    $response = $next($request, $response);
    return $response;
  }else{
    $status = 500;
    $rpta = json_encode(
      [
        'tipo_mensaje' => 'error',
        'mensaje' => [
          'No se puede acceder al recurso',
          'CSRF Token key error'
        ]
      ]
    );
    return $response->withStatus($status)->write($rpta);
  }
};

$mw_session_true = function ($request, $response, $next) {
  $settings = require 'settings.php';
  $continuar = true;
  $env = $_ENV['ENV'];
  if($settings['settings']['constants'][$env]['validation_session'] == 'able'){
    if (array_key_exists('status', $_SESSION)) {
      if($_SESSION['status'] != 'active'){
        $continuar = false;
      }
    }else{
      $continuar = false;
    }
  }
  if($continuar == true){
    $response = $next($request, $response);
    return $response;
  }else{
    $status = 500;
    $response = $response->withRedirect($this->constants['base_url'] . 'error/access/505');
    return $response;
  }
};

$mw_session_false = function ($request, $response, $next) {
  $settings = require 'settings.php';
  $error = true;
  if($settings['settings']['constants']['validation_session'] == 'able'){
    if (array_key_exists('status', $_SESSION)) {
      if($_SESSION['status'] == 'active'){
        $error = false;
      }
    }else{
      $error = true;
    }
  }
  if($error == true){
    $response = $next($request, $response);
    return $response;
  }else{
    $status = 500;
    $response = $response->withRedirect($this->constants['base_url']);
    return $response;
  }
};

$mw_before_all = function ($request, $response, $next){
  $settings = require 'settings.php';
  $error = true;
  $env = $_ENV['ENV'];
  if($settings['settings']['constants'][$env]['check_https'] == 'able'){
    // check http o https
    if (isset($_SERVER['HTTPS']) &&
      ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
      isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
      $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
      $protocol = 'https://';
    }
    else {
      $protocol = 'http://';
    }
    // check www
    if($protocol == 'http://'){
      $url =  "{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
      $escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
      $url = explode(".", $escaped_url);
      if($url[0] == 'www'){
          unset($url[0]);
          $escaped_url = implode(".", $url);
      }
      header( "Location: https://" . $escaped_url );
      exit();
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
        exit();
      }
    }
  }
  $response = $next($request, $response);
  return $response;
};

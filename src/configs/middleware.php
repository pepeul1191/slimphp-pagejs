<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
$mw_ambiente_csrf = function ($request, $response, $next) {
  $settings = require 'settings.php';
  $continuar = true;
  if($settings['settings']['constants']['ambiente_csrf'] == 'activo'){
    if($request->getHeader($settings['settings']['constants']['csrf']['key']) != $settings['settings']['constants']['csrf']['secret']){
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

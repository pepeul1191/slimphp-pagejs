<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Controller\DepartamentoController;
use Controller\DistritoController;
use Controller\ErrorController;
use Controller\HomeController;
use Controller\LoginController;
use Controller\ProvinciaController;
use Admin\Controller\ViewController;

// Routes
$app->get('/demo/[{name}]', function (Request $request, Response $response, array $args) {
  // Sample log message
  $this->logger->info("Slim-Skeleton '/' route");
  // Render index view
  return $this->renderer->render($response, 'index.phtml', $args);
});
//login
$app->get('/login', LoginController::class . ':index')->add($mw_session_false);
$app->get('/login/sign_in', LoginController::class . ':signIn')->add($mw_session_false);
$app->get('/login/reset', LoginController::class . ':reset')->add($mw_session_false);
$app->post('/login/reset', LoginController::class . ':resetPassword')->add($mw_session_false);
$app->post('/login', LoginController::class . ':access');
$app->get('/login/ver', LoginController::class . ':ver');
$app->get('/login/cerrar', LoginController::class . ':cerrar');
//error
$app->get('/error/access/{numero}', ErrorController::class . ':access');
//home
$app->get('/', HomeController::class . ':view')->add($mw_session_true);
//servicios REST
// access
$app->get('/access/', \Access\Controller\ViewController::class . ':index');

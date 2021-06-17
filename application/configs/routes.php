<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Controller\ErrorController;
use Controller\HomeController;
use Controller\LoginController;

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
$app->post('/login/sign_in', LoginController::class . ':create')->add($mw_session_false);
$app->get('/login/reset', LoginController::class . ':reset')->add($mw_session_false);
$app->post('/login/reset', LoginController::class . ':resetPassword')->add($mw_session_false);
$app->post('/login', LoginController::class . ':access');
$app->get('/oauth/callback', LoginController::class . ':oauth_callback');
$app->get('/user', LoginController::class . ':user');
$app->get('/sign_out', LoginController::class . ':sign_out');
//error
$app->get('/error/access/{numero}', ErrorController::class . ':access');
//home
$app->get('/', HomeController::class . ':view')->add($mw_session_true);
//servicios REST

<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Controller\ErrorController;
use Controller\HomeController;
use Controller\LoginController;
use Controller\UserController;
use Controller\OAuthController;
use Controller\EventController;

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
$app->get('/oauth/callback', OAuthController::class . ':googleCallback');
$app->get('/user', UserController::class . ':view');
$app->get('/exit', UserController::class . ':exit');
$app->get('/sign_out', UserController::class . ':sign_out');
//app
$app->get('/event/list', EventController::class . ':list');
$app->get('/event/document', EventController::class . ':studentDocuments');
$app->get('/event/video', EventController::class . ':studentVideos');
//error
$app->get('/error/access/{numero}', ErrorController::class . ':access');
//home
$app->get('/', HomeController::class . ':view')->add($mw_session_true);
$app->get('/courses', HomeController::class . ':view')->add($mw_session_true);
$app->get('/user/edit', HomeController::class . ':view')->add($mw_session_true);
//servicios REST

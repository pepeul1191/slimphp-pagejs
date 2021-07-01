<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Controller\ErrorController;
use Controller\HomeController;
use Controller\LoginController;
use Controller\UserController;
use Controller\OAuthController;
use Controller\EventController;
use Controller\DocumentController;
use Controller\DistrictController;

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
$app->get('/user/session', UserController::class . ':view');
$app->get('/exit', UserController::class . ':exit');
$app->get('/sign_out', UserController::class . ':sign_out');
//app
$app->get('/event/list', EventController::class . ':list');
$app->get('/event/recent', EventController::class . ':recentList');
$app->get('/event/document', EventController::class . ':studentDocuments');
$app->get('/event/video', EventController::class . ':studentVideos');
$app->get('/document/get', DocumentController::class . ':get')->add($mw_session_true);
$app->get('/user/get', UserController::class . ':get')->add($mw_session_true);
$app->post('/user/update', UserController::class . ':update')->add($mw_session_true);
$app->get('/district/search', DistrictController::class . ':search')->add($mw_session_true);
//error
$app->get('/error/access/{numero}', ErrorController::class . ':access');
//home
$app->get('/', HomeController::class . ':view')->add($mw_session_true);
$app->get('/courses', HomeController::class . ':view')->add($mw_session_true);
$app->get('/user', HomeController::class . ':view')->add($mw_session_true);
$app->get('/document', HomeController::class . ':view')->add($mw_session_true);
$app->get('/events', HomeController::class . ':view')->add($mw_session_true);
$app->get('/video', HomeController::class . ':view')->add($mw_session_true);
$app->get('/document/{id}', HomeController::class . ':view')->add($mw_session_true);
$app->get('/video/{id}', HomeController::class . ':view')->add($mw_session_true);
//servicios REST

<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Controller\ErrorController;
use Controller\HomeController;
use Controller\SpeakerController;
use Controller\EventController;
use Controller\EmailController;
use Controller\SpecialismController;
use Controller\StudentController;

// Routes
$app->get('/demo/[{name}]', function (Request $request, Response $response, array $args) {
  // Sample log message
  $this->logger->info("Slim-Skeleton '/' route");
  // Render index view
  return $this->renderer->render($response, 'index.phtml', $args);
});
//error
$app->get('/error/access/{numero}', ErrorController::class . ':access');
// site
$app->get('/', HomeController::class . ':view');
$app->get('/nosotros', HomeController::class . ':view');
$app->get('/capacitaciones', HomeController::class . ':view');
$app->get('/ponentes', HomeController::class . ':view');
$app->get('/contacto', HomeController::class . ':view');
$app->get('/speaker/random-list', SpeakerController::class . ':randomList');
$app->get('/event/recent-list', EventController::class . ':recentList');
$app->get('/event/search', EventController::class . ':search');
$app->get('/specialism/list', SpecialismController::class . ':list');
$app->get('/student/check', StudentController::class . ':check');
$app->post('/email/send', EmailController::class . ':send');
//servicios REST

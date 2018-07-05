<?php

use Slim\Http\Request;
use Slim\Http\Response;
require_once 'src/controllers/home_controller.php';
require_once 'src/controllers/departamento_controller.php';
require_once 'src/controllers/provincia_controller.php';

// Routes
$app->get('/demo/[{name}]', function (Request $request, Response $response, array $args) {
  // Sample log message
  $this->logger->info("Slim-Skeleton '/' route");
  // Render index view
  return $this->renderer->render($response, 'index.phtml', $args);
});
$app->get('/', \HomeController::class . ':view');
$app->get('/departamento/listar', \DepartamentoController::class . ':listar');
$app->get('/provincia/listar/{departamento_id}', \ProvinciaController::class . ':listar');

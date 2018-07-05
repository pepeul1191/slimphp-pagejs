<?php

use Slim\Http\Request;
use Slim\Http\Response;
require_once 'src/controllers/home_controller.php';
require_once 'src/controllers/login_controller.php';
require_once 'src/controllers/departamento_controller.php';
require_once 'src/controllers/provincia_controller.php';
require_once 'src/controllers/distrito_controller.php';

// Routes
$app->get('/demo/[{name}]', function (Request $request, Response $response, array $args) {
  // Sample log message
  $this->logger->info("Slim-Skeleton '/' route");
  // Render index view
  return $this->renderer->render($response, 'index.phtml', $args);
});
//login
$app->get('/login', \LoginController::class . ':view');
$app->post('/login/acceder', \LoginController::class . ':acceder');
$app->get('/login/ver', \LoginController::class . ':ver');
$app->get('/login/cerrar', \LoginController::class . ':cerrar');
//home
$app->get('/', \HomeController::class . ':view');
//servicios REST
$app->get('/departamento/listar', \DepartamentoController::class . ':listar')->add($mw_ambiente_csrf);
$app->get('/provincia/listar/{departamento_id}', \ProvinciaController::class . ':listar')->add($mw_ambiente_csrf);
$app->get('/distrito/listar/{provincia_id}', \DistritoController::class . ':listar')->add($mw_ambiente_csrf);
$app->get('/distrito/buscar', \DistritoController::class . ':buscar')->add($mw_ambiente_csrf);
$app->get('/distrito/nombre/{distrito_id}', \DistritoController::class . ':nombre')->add($mw_ambiente_csrf);

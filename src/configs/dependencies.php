<?php
// DIC configuration
$container = $app->getContainer();
// view renderer
$container['renderer'] = function ($c) {
  $settings = $c->get('settings')['renderer'];
  return new Slim\Views\PhpRenderer($settings['template_path']);
};
// monolog
$container['logger'] = function ($c) {
  $settings = $c->get('settings')['logger'];
  $logger = new Monolog\Logger($settings['name']);
  $logger->pushProcessor(new Monolog\Processor\UidProcessor());
  $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
  return $logger;
};

$container['constants'] = function ($c) {
  return $c->get('settings')['constants'];
};

$container['view'] = function ($c) {
  return function($response, $partial, $template, $locals) {
    $view = new Slim\Views\PhpRenderer(__DIR__ . '/../templates/');
    $view->render($response, 'partials/' . $partial . '_header.phtml', [
      'title' => 'Ubicaciones'
    ]);
    $view->render($response, $template, [
      'title' => 'Ubicaciones'
    ]);
    $view->render($response, 'partials/' . $partial . '_footer.phtml', [
      'title' => 'Ubicaciones'
    ]);
  };
};

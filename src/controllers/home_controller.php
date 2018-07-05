<?php

class HomeController
{
  protected $container;

  public function __construct(\Slim\Container $container) {
    $this->container = $container;
  }

  public function view($request, $response, $args) {
    $rpta = '';
    $status = 200;

    $this->container->renderer->render($response, 'partials/blank_header.phtml', [
        'title' => 'Ubicaciones'
    ]);
    $this->container->renderer->render($response, 'ubicaciones/index.phtml', [
        'title' => 'Ubicaciones'
    ]);
    $this->container->renderer->render($response, 'partials/blank_footer.phtml', [
        'title' => 'Ubicaciones'
    ]);
  }
}

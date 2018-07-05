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
    $constants = $this->container->constants;
    $view = $this->container->view;
    return $view($response, 'blank', 'home/index.phtml', $constants);
  }
}

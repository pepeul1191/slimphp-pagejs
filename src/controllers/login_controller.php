<?php

class LoginController
{
  protected $container;

  public function __construct(\Slim\Container $container) {
    $this->container = $container;
  }

  public function view($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $locals = [
      'constants' => $this->container->constants,
      'title' => 'Login',
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/index.phtml', $locals);
  }
}

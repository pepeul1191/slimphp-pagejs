<?php

require_once 'src/models/departamento.php';

class Controller
{
  protected $container;

  public function __construct(\Slim\Container $container) {
    $this->container = $container;
    $this->constants = $container->constants;
  }


}

<?php

class HomeController extends Controller
{
  public function view($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $locals = [
      'constants' => $this->constants,
      'title' => 'Ubicaciones',
    ];
    $view = $this->container->view;
    return $view($response, 'app', 'home/index.phtml', $locals);
  }
}

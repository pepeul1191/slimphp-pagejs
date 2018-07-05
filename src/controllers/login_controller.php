<?php

class LoginController extends Controller
{
  public function view($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $locals = [
      'constants' => $this->constants,
      'title' => 'Login',
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/index.phtml', $locals);
  }
}

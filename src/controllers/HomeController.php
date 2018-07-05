<?php

class HomeController
{
  public function home($request, $response, $args) {
    //return $this->renderer->render($response, 'index.phtml', $args);
    return 'home';
  }
}

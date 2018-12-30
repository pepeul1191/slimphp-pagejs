<?php

namespace Admin\Controller;

class ViewController extends \Configs\Controller
{
  public function index($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $rpta = $this->load_titles('sp');
    return $response->withStatus($status)->write($rpta['admin']);
  }
}

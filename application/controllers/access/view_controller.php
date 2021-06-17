<?php

namespace Access\Controller;

class ViewController extends \Configs\Controller
{
  public function index($request, $response, $args) {
    # data
    $rpta = '';
    $status = 200;
    $language = 'sp';
    # helpers
    $this->load_helper('access/view');
    $csss = $this->load_css(index_css($this->constants));
    $jss = $this->load_js(index_js($this->constants));
    $modules = $this->menu_modules($language, 'access', 'access/');
    $items = $this->menu_items($language, 'access', 'access/');
    # view
    $locals = [
      'constants' => $this->constants,
      'title' => $this->load_titles()['sp']['access_index'],
      'csss' => $csss,
      'jss'=> $jss,
      'modules' => $modules,
      'items' => $items,
      'mensaje' => '',
      'data' => json_encode(array(
        'mensaje' => false,
        'titulo_pagina' => 'Gestión de Ubicaciones',
        'modulo' => 'Ubicaciones'
      )),
    ];
    $view = $this->container->view;
    return $view($response, 'app', 'access/index.phtml', $locals);
  }
}

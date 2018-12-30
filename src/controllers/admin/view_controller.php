<?php

namespace Admin\Controller;

class ViewController extends \Configs\Controller
{
  public function index($request, $response, $args) {
    # data
    $rpta = '';
    $status = 200;
    $language = 'sp';
    # helpers
    $this->load_helper('admin/view');
    $csss = $this->load_css(index_css($this->constants));
    $jss = $this->load_js(index_js($this->constants));
    $modules = $this->menu_modules($language, 'admin', 'admin/');
    $items = $this->menu_items($language, 'admin', 'admin/');
    # view
    $locals = [
      'constants' => $this->constants,
      'title' => $this->load_titles()['sp']['admin_index'],
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
    return $view($response, 'app', 'admin/index.phtml', $locals);
  }
}

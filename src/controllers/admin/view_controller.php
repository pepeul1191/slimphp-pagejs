<?php

namespace Admin\Controller;

class ViewController extends \Configs\Controller
{
  public function index($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $language = 'sp';
    $this->load_helper('admin/view');
    $locals = [
      'constants' => $this->constants,
      'title' => $this->load_titles()['sp']['admin_index'],
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
      'mensaje' => '',
      'menu' => '[{"url" : "", "nombre" : "Ubicaciones"}]',
      'items' => '[{"subtitulo":"","items":[{"item":"Ubicaciones del Perú","url":"#/ubicacion"},{"item":"Autocompletar","url":"#/autocompletar"}]}]',
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

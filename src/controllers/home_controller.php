<?php

class HomeController extends Controller
{
  public function view($request, $response, $args) {
    $this->load_helper('home');
    $rpta = '';
    $status = 200;
    $locals = [
      'constants' => $this->constants,
      'title' => 'Login',
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
    return $view($response, 'app', 'home/index.phtml', $locals);
  }
}

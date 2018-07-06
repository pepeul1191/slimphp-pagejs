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
      'menu' => '[{"url" : "accesos", "nombre" : "Accesos"},{"url" : "libros", "nombre" : "Libros"}]',
      'items' => '[{"subtitulo":"","items":[{"item":"Gestión de Sistemas","url":"accesos/#/sistema"},{"item":"Gestión de Usuarios","url":"accesos/#/usuario"}]}]',
      'data' => json_encode(array(
        'mensaje' => false,
        'titulo_pagina' => 'Gestión de Accesos',
        'modulo' => 'Accesos'
      )),
    ];
    $view = $this->container->view;
    return $view($response, 'app', 'home/index.phtml', $locals);
  }
}

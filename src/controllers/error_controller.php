<?php

class ErrorController extends Controller
{
  public function access($request, $response, $args) {
    $this->load_helper('error');
    $rpta = '';
    $status = 404;
    $numero = $args['numero'];
    $error = [];
    switch ($numero) {
      case '404':
        $error = [
          'numero' => 404,
          'mensaje' => 'Archivo no encontrado',
          'descripcion' => 'La página que busca no se encuentra en el servidor',
          'icono' => 'fa fa-exclamation-triangle'
        ];
        $status = 404;
        break;
      case '501':
        $error = [
          'numero' => 501,
          'mensaje' => 'Página en Contrucción',
          'descripcion' => 'Lamentamos el incoveniente, estamos trabajando en ello.',
          'icono' => 'fa fa-code-fork'
        ];
        $status = 500;
        break;
      case '5050':
        $error = [
          'numero' => 5050,
          'mensaje' => 'Acceso restringido',
          'descripcion' => 'No cuenta con los privilegios necesarios.',
          'icono' => 'fa fa-ban'
        ];
        $status = 500;
        break;
      case '505':
        $error = [
          'numero' => 5050,
          'mensaje' => 'Acceso restringido',
          'descripcion' => 'Necesita estar logueado.',
          'icono' => 'fa fa-ban'
        ];
        $status = 500;
        break;
      case '8080':
        $error = [
          'numero' => 8080,
          'mensaje' => 'Tiempo de la sesion agotado',
          'descripcion' => 'Vuelva a ingresar al sistema.',
          'icono' => 'fa fa-clock-o'
        ];
        $status = 500;
        break;
      default:
        $error = [
          'numero' => 404,
          'mensaje' => 'Archivo no encontrado',
          'descripcion' => 'La página que busca no se encuentra en el servidor',
          'icono' => 'fa fa-exclamation-triangle'
        ];
        $status = 404;
    }
    $locals = [
      'constants' => $this->constants,
      'title' => 'Error',
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
      'error' => $error
    ];
    $view = $this->container->view;
    $response = $response->withStatus($status);
    return $view($response, 'blank', 'error/access.phtml', $locals);
  }
}

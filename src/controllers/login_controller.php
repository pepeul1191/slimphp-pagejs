<?php

class LoginController extends Controller
{
  public function view($request, $response, $args) {
    $this->load_helper('login');
    $rpta = '';
    $status = 200;
    $locals = [
      'constants' => $this->constants,
      'title' => 'Login',
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
      'mensaje' => '',
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/index.phtml', $locals);
  }

  public function acceder($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $mensaje = '';
    $continuar = true;
    $csrf_request = $request->getParam($this->constants['csrf']['key']);
    $csrf_app = $this->constants['csrf']['secret'];
    if($csrf_app != $csrf_request){
      $mensaje = 'Token CSRF no es el correcto';
      $continuar = false;
    }
    if($continuar == true){
      $usuario = $request->getParam('usuario');
      $contrasenia = $request->getParam('contrasenia');
      if($usuario != $this->constants['login']['usuario'] && $contrasenia != $this->constants['login']['contrasenia']){
        $continuar = false;
        $mensaje = 'Usuario y/o contraenia no coinciden';
      }
    }
    if($continuar == true){
      $_SESSION['usuario'] = $usuario;
      $_SESSION['estado'] = 'activo';
      $_SESSION['tiempo'] = date('Y-m-d H:i:s');
      $response = $response->withRedirect($this->constants['base_url']);
      return $response;
    }else{
      $status = 500;
      $this->load_helper('login');
      $locals = [
        'constants' => $this->constants,
        'title' => 'Login',
        'csss' => $this->load_css(index_css($this->constants)),
        'jss'=> $this->load_js(index_js($this->constants)),
        'mensaje' => $mensaje,
      ];
      $view = $this->container->view;
      return $view($response, 'blank', 'login/index.phtml', $locals);
    }
  }

  public function ver($request, $response, $args){
    $rpta = '';
    $status = 200;
    if (array_key_exists('estado', $_SESSION)) {
      if($_SESSION['estado'] != 'activo'){
        $rpta = '<h1>El usuario no se encuentra logueado</h1>';
      }else{
        $rpta = '<h1>Usuario Logeado</h1><ul><li>' .
          $_SESSION['usuario'] . '</li><li>' .
          $_SESSION['tiempo'] . '</li><li>' .
          $_SESSION['estado'] . '</li></ul>';
      }
    }else{
      $rpta ='<h2>El usuario no se encuentra logueado</h2>';
      $status = 500;
    }
    return $response->withStatus($status)->write($rpta);
  }

  public function cerrar($request, $response, $args){
    session_destroy();
    $response = $response->withRedirect($this->constants['base_url'] . 'login', 200);
    return $response;
  }
}

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
      //TODO habilitar session
      return $response->withRedirect($this->constants['base_url'], 301);
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
}

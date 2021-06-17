<?php

namespace Controller;

class LoginController extends \Configs\Controller
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
      'message' => '',
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/index.phtml', $locals);
  }

  public function access($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $mensaje = '';
    $continue = true;
    $csrf_request = $request->getParam($this->constants['csrf']['key']);
    $csrf_app = $this->constants['csrf']['secret'];
    if($csrf_app != $csrf_request){
      $mensaje = 'Token CSRF no es el correcto';
      $continue = false;
    }
    if($continue == true){
      $user = $request->getParam('user');
      $password = $request->getParam('password');
      if($user != $this->constants['login']['user'] or $password != $this->constants['login']['password']){
        $continue = false;
        $mensaje = 'Usuario y/o contraenia no coinciden';
      }
    }
    if($continue == true){
      $_SESSION['user'] = $user;
      $_SESSION['status'] = 'active';
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
    if (array_key_exists('status', $_SESSION)) {
      if($_SESSION['status'] != 'active'){
        $rpta = '<h1>El usuario no se encuentra logueado</h1>';
      }else{
        $rpta = '<h1>Usuario Logeado</h1><ul><li>' .
          $_SESSION['user'] . '</li><li>' .
          $_SESSION['tiempo'] . '</li><li>' .
          $_SESSION['status'] . '</li></ul>';
      }
    }else{
      $rpta ='<h2>El usuario no se encuentra logueado</h2>';
      $status = 500;
    }
    return $response->withStatus($status)->write($rpta);
  }

  public function cerrar($request, $response, $args){
    session_destroy();
    return $response->withRedirect($this->constants['base_url'] . 'login');
  }
}

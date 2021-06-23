<?php

namespace Controller;

use Unirest\Request;

class LoginController extends \Configs\Controller
{
  public function index($request, $response, $args) {
    $this->load_helper('login');
    $message = $request->getParam('message'); // 0 false, 1 true
    $rpta = '';
    $status = 200;
    $locals = [
      'constants' => $this->constants,
      'title' => 'Login',
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
      'oauth_client_id' => $this->env['OAUTH_CLIENT_ID'],
      'oauth_callback' => $this->env['OAUTH_CALLBACK'],
      'message' => index_message($message)['message'],
      'message_color' => index_message($message)['color-message'],
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/index.phtml', $locals);
  }

  public function signIn($request, $response, $args) {
    $this->load_helper('login');
    $rpta = '';
    $status = 200;
    $locals = [
      'constants' => $this->constants,
      'title' => 'Login',
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
      'message' => '',
      'message_color' => '',
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/sign_in.phtml', $locals);
  }

  public function reset($request, $response, $args) {
    $this->load_helper('login');
    $rpta = '';
    $status = 200;
    $locals = [
      'constants' => $this->constants,
      'title' => 'Login',
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
      'message' => '',
      'message_color' => '',
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/reset.phtml', $locals);
  }

  public function resetPassword($request, $response, $args){
    // https://accounts.google.com/signin/v2/recoveryidentifier
    $email = $request->getParam('email');
    $message = '';
    if(strpos($email, 'gmail')){
      $message = 'Para recuperar su acceso a su cuenta de Google, usar el siguiente <a href="https://accounts.google.com/signin/v2/recoveryidentifier">link</a> que lo llevará a Google';
    }else{
      $message = 'Cuenta no registrada';
    }
    $status = 500;
    $this->load_helper('login');
    $locals = [
      'constants' => $this->constants,
      'title' => 'Login',
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
      'message_color' => 'text-danger',
      'message' => $message,
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/reset.phtml', $locals);
  }

  public function access($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $message = '';
    $continue = true;
    $csrf_request = $request->getParam($this->constants['csrf']['key']);
    $csrf_app = $this->constants['csrf']['secret'];
    if($csrf_app != $csrf_request){
      $message = 'Token CSRF no es el correcto';
      $continue = false;
    }
    if($continue == true){
      $continue = false;
      $message = 'Usuario y/o contraenia no coinciden';
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
        'message_color' => 'text-danger',
        'message' => $message,
      ];
      $view = $this->container->view;
      return $view($response, 'blank', 'login/index.phtml', $locals);
    }
  }

  public function create($request, $response, $args){
    $user = $request->getParam('user');
    $email = $request->getParam('email');
    $password1 = $request->getParam('password1');
    $password2 = $request->getParam('password2');
    $message = '';
    $continue = true;
    if($password1 != $password2){
      $continue = false;
      $message = 'Contraseñas no coinciden';
    }else{
      // send mail
      $message = 'Ha ocurrido un error en crear su cuenta. Puede mandarnos un correo presionando <a href="mailto:info@legisjuristas.com">aquí</a> para poder ayudarlo.';
    }
    $status = 500;
    $this->load_helper('login');
    $locals = [
      'constants' => $this->constants,
      'title' => 'Login',
      'csss' => $this->load_css(index_css($this->constants)),
      'jss'=> $this->load_js(index_js($this->constants)),
      'message_color' => 'text-danger',
      'message' => $message,
    ];
    $view = $this->container->view;
    return $view($response, 'blank', 'login/sign_in.phtml', $locals);
  }
}

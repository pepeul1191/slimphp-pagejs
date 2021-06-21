<?php

namespace Controller;

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

  public function user($request, $response, $args){
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

  public function oauth_callback($request, $response, $args){
    $code = $request->getParam('code');
    $url = 'https://oauth2.googleapis.com/token';
    // do post with curl
    $curl_token = curl_init();
    $params = array(
      'client_id' => $this->env['OAUTH_CLIENT_ID'],
      'client_secret' => $this->env['OAUTH_SECRET'],
      'code' => $code,
      'grant_type' => 'authorization_code',
      'redirect_uri' => $this->constants['redirect_url'],
    );
    curl_setopt($curl_token, CURLOPT_URL, $url);
    curl_setopt($curl_token, CURLOPT_POST, true);
    curl_setopt($curl_token, CURLOPT_POSTFIELDS, $params);
    curl_setopt($curl_token, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl_token);
    $data = json_decode($response);
    curl_close($curl_token);
    // get user info with token and store it in session
    if($data->access_token != ''){
      $curl_user = curl_init();
      curl_setopt($curl_user, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v1/userinfo?access_token=' . $data->access_token);
      curl_setopt($curl_user, CURLOPT_RETURNTRANSFER, true);
      $user_data = json_decode(curl_exec($curl_user));
      curl_close($curl_user);
      session_start();
      $_SESSION['user_data'] = $user_data;
      $_SESSION['access_token'] = $data->access_token;
      $_SESSION['user_nick'] = $user_data->name;
      $_SESSION['user_name'] = $user_data->name;
      $_SESSION['user_img'] = $user_data->picture;
      $_SESSION['user_email'] = $user_data->email;
      $_SESSION['app'] = 'Google';
      $_SESSION['logout_url'] = 'https://accounts.google.com/Logout?continue=https://appengine.google.com/_ah/logout?continue=' . $this->constants['base_url'] . 'sign_out';
      header('Location: ' . $this->constants['base_url'] . 'login?message=sign-out-success');
      exit();
    }else{
      header('Location: ' . $this->constants['base_url'] . 'login?message=error-ouath');
      exit();
    }
  }

  public function sign_out($request, $response, $args){
    session_destroy();
    return $response->withRedirect($this->constants['base_url'] . 'login?message=sign-out-success');
  }
}

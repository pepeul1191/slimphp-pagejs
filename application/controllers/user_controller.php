<?php

namespace Controller;

use Unirest\Request;

class UserController extends \Configs\Controller
{
  public function view($request, $response, $args){
    $rpta = '';
    $status = 200;
    var_dump($_SESSION);
    if (array_key_exists('status', $_SESSION)) {
      if($_SESSION['status'] != 'active'){
        $rpta = '<h1>El usuario no se encuentra logueado</h1>';
      }else{
        var_dump($_SESSION);
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

  public function exit($request, $response, $args){
    header('Location: ' . $_SESSION['logout_url']);
    exit();
  }

  public function sign_out($request, $response, $args){
    session_destroy();
    return $response->withRedirect($this->constants['base_url'] . 'login?message=sign-out-success');
  }
}

?>

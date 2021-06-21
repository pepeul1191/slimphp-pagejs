<?php

if ( ! function_exists('index_css'))
{
  function index_css($constants){
    $resp = null;
    switch($constants['env_static']){
      case 'desarrollo':
        $resp = [
          'bower_components/bootstrap/dist/css/bootstrap.min',
          'bower_components/font-awesome/css/font-awesome.min',
          'bower_components/swp-backbone/assets/css/constants',
          'bower_components/swp-backbone/assets/css/login',
          'assets/css/login',
				  //'css/style'
        ];
        break;
      case 'produccion':
        $resp = [
          'dist/login.min',
        ];
        break;
    }
    return $resp;
  }
}

if ( ! function_exists('index_js'))
{
  function index_js($constants){
    $resp = null;
    switch($constants['env_static']){
      case 'desarrollo':
        $resp = [
        ];
        break;
      case 'produccion':
        $resp = [
        ];
        break;
    }
    return $resp;
  }
}

if ( ! function_exists('index_message'))
{
  function index_message($type){
    $resp = null;
    switch($type){
      case 'error-ouath':
        $resp = [
          'message' => 'Ocurrió un error en iniciar su sesión',
          'color-message' => 'text-danger',
        ];
        break;
      case 'sign-out-success':
        $resp = [
          'message' => 'Cerró sesión con éxito',
          'color-message' => 'text-success',
        ];
        break;
      default:
        $resp = [
          'message' => '',
          'color-message' => '',
        ];
        break;
    }
    return $resp;
  }
}

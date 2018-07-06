<?php

if ( ! function_exists('index_css'))
{
  function index_css($constants){
    $rpta = null;
    switch($constants['ambiente_static']){
      case 'desarrollo':
        $rpta = [
          'bower_components/bootstrap/dist/css/bootstrap.min',
          'bower_components/font-awesome/css/font-awesome.min',
          'assets/css/constants',
          'assets/css/error',
        ];
        break;
      case 'produccion':
        $rpta = [
          'dist/login.min',
        ];
        break;
    }
    return $rpta;
  }
}

if ( ! function_exists('index_js'))
{
  function index_js($constants){
    $rpta = null;
    switch($constants['ambiente_static']){
      case 'desarrollo':
        $rpta = [
        ];
        break;
      case 'produccion':
        $rpta = [
        ];
        break;
    }
    return $rpta;
  }
}

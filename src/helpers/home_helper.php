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
          'bower_components/swp-backbone/assets/css/constants',
          'bower_components/swp-backbone/assets/css/login',
				  //'css/style'
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

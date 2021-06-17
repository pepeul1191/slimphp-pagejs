<?php

if ( ! function_exists('index_css'))
{
  function index_css($constants){
    $rpta = null;
    switch($constants['env_static']){
      case 'desarrollo':
        $rpta = [
          'bower_components/bootstrap/dist/css/bootstrap.min',
				  'bower_components/font-awesome/css/font-awesome.min',
          'bower_components/swp-backbone/assets/css/constants',
          'bower_components/swp-backbone/assets/css/dashboard',
          'bower_components/swp-backbone/assets/css/table',
          'assets/css/constants',
          'assets/css/styles',
        ];
        break;
      case 'produccion':
        $rpta = [
          'dist/ubicaciones.min',
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
    switch($constants['env_static']){
      case 'desarrollo':
        $rpta = [
          'dist/vendors',
          'dist/app',
        ];
        break;
      case 'produccion':
        $rpta = [
          'dist/ubicaciones.min',
        ];
        break;
    }
    return $rpta;
  }
}

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
          'assets/css/constants',
          'assets/css/styles',
          'assets/css/carousel',
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
          'bower_components/jquery/dist/jquery.min',
          'bower_components/bootstrap/dist/js/bootstrap.min',
          'assets/js/app',
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

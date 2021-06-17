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
          'access/assets/css/constants',
          'access/assets/css/styles',
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
          'bower_components/underscore/underscore-min',
          'bower_components/backbone/backbone-min',
          'bower_components/handlebars/handlebars.min',
          'bower_components/swp-backbone/views/table',
          'bower_components/swp-backbone/views/modal',
          'bower_components/swp-backbone/views/upload',
          'bower_components/swp-backbone/views/autocomplete',
          'access/models/permission',
          'access/models/system',
          'access/models/role',
          'access/collections/permission_collection',
          'access/collections/role_collection',
          'access/collections/system_collection',
          'access/data/table_system_data',
          'access/data/table_permission_data',
          'access/data/table_role_data',
          'access/data/table_role_permission_data',
          'access/data/modal_system_permission_data',
          'access/data/modal_system_role_data',
          'access/views/system_view',
          'access/views/system_permission_view',
          'access/views/system_role_view',
          'access/routes/access',

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

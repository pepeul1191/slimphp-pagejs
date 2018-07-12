<?php

namespace Configs;

class Controller
{
  protected $container;

  public function __construct(\Slim\Container $container) {
    $this->container = $container;
    $this->constants = $container->constants;
  }

  public function load_helper($helper){
    include __DIR__ . '/../helpers/' . $helper . '_helper.php';
  }

  public function load_css($array_css){
    $rpta = '';
    foreach ($array_css as &$css) {
      $temp = '<link rel="stylesheet" type="text/css" href="' . $this->constants['static_url'] . $css . '.css"/>';
      $rpta = $rpta . $temp;
    }
    return $rpta;
  }

  function load_js($array_js){
    $rpta = '';
    foreach ($array_js as &$js) {
      $temp = '<script src="' . $this->constants['static_url'] . $js . '.js" type="text/javascript"></script>';
      $rpta = $rpta . $temp;
    }
    return $rpta;
  }
}

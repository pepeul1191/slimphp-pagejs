<?php

namespace Configs;

use Symfony\Component\Yaml\Yaml;
use Dotenv\Dotenv;

class Controller
{
  protected $container;

  public function __construct(\Slim\Container $container) {
    $dotenv = Dotenv::createImmutable(__DIR__);
    $this->env = $dotenv->load();
    $this->container = $container;
    $this->constants = $container->constants[$_ENV['ENV']];
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

  function load_titles(){
    return Yaml::parseFile(__DIR__ . '/../contents/_titles.yml');
  }

  function menu_modules($language, $module, $url_active){
    $menu = Yaml::parseFile(__DIR__ . '/../contents/_menus.yml')[$language][$module];
    $rpta = '';
    foreach ($menu as $m) {
      $t = '';
      if( $url_active == $m['url']){
        $t = '<a href="' . $this->constants['base_url'] . $m['url'] . '" class="nav-active">' . $m['name'] . '</a>';
      } else {
        $t = '<a href="' . $this->constants['base_url'] . $m['url'] . '" class="">' . $m['name'] . '</a>';
      }
      $rpta = $rpta . $t;
    }
    return $rpta;
  }

  function menu_items($language, $module, $url_active){
    $menu = Yaml::parseFile(__DIR__ . '/../contents/_menus.yml')[$language][$module];
    $rpta = '';
    foreach ($menu as $m) {
      if ($url_active == $m['url']){
        $subtitles = $m['subtitles'];
        foreach ($subtitles as $s) {
          $t = '<li class="li-submodulo">' . $s['name'] . '</li>';
          $rpta = $rpta . $t;
          $items = $s['items'];
          foreach ($items as $i) {
            $t = '<li class="li-item"><a href="' . $this->constants['base_url'] . $i['url'] . '">' . $i['name'] . '</a></li>';
            $rpta = $rpta . $t;
          }
        }
      }
    }
    return $rpta;
  }
}

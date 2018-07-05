<?php

require_once 'src/models/departamento.php';

class DepartamentoController
{
  protected $view;

  public function __construct(\Slim\Container $container) {
    $this->container = $container;
  }

  public function view($request, $response, $args) {
    $rpta = '';
    $status = 200;
    var_dump($settings['template_path']);
    $this->container->renderer->render($response, 'partials/blank_header.phtml', [
        'title' => 'Ubicaciones'
    ]);
    $this->container->renderer->render($response, 'ubicaciones/index.phtml', [
        'title' => 'Ubicaciones'
    ]);
    $this->container->renderer->render($response, 'partials/blank_footer.phtml', [
        'title' => 'Ubicaciones'
    ]);
  }

  public function listar($request, $response, $args) {
    $rpta = '';
    $status = 200;
    try {
      $rs = Model::factory('Departamentos', 'ubicaciones')
      	->select('id')
      	->select('nombre')
      	->find_array();
      $rpta = json_encode($rs);
    }catch (Exception $e) {
      $status = 500;
      $rpta = json_encode(
        [
          'tipo_mensaje' => 'error',
          'mensaje' => [
  					'No se ha podido listar los departamentos',
  					$e->getMessage()
  				]
        ]
      );
    }
    return $response->withStatus($status)->write($rpta);
  }
}

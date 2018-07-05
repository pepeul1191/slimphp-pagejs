<?php

require_once 'src/models/provincia.php';

class ProvinciaController
{
  protected $container;

  public function __construct(\Slim\Container $container) {
    $this->container = $container;
  }

  public function listar($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $departamento_id = $args['departamento_id'];
    try {
      $rs = Model::factory('Provincia', 'ubicaciones')
      	->select('id')
      	->select('nombre')
      	->where('departamento_id', $departamento_id)
      	->find_array();
      $rpta = json_encode($rs);
    }catch (Exception $e) {
      $status = 500;
      $rpta = json_encode(
        [
          'tipo_mensaje' => 'error',
          'mensaje' => [
  					'No se ha podido listar los provincias del departamento',
  					$e->getMessage()
  				]
        ]
      );
    }
    return $response->withStatus($status)->write($rpta);
  }
}

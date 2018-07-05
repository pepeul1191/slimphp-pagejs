<?php

require_once 'src/models/Departamento.php';
//use Models\Departmaneto;

class DepartamentoController
{
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
    //$response->setStatus(400);
    return $response->getBody()->write($rpta);
  }
}

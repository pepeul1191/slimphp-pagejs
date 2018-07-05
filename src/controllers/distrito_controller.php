<?php

require_once 'src/models/distrito.php';
require_once 'src/models/vw_distrito_provincia_departamento.php';

class DistritoController extends Controller
{
  public function listar($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $provincia_id = $args['provincia_id'];
    try {
      $rs = Model::factory('Distrito', 'ubicaciones')
      	->select('id')
      	->select('nombre')
      	->where('provincia_id', $provincia_id)
      	->find_array();
      $rpta = json_encode($rs);
    }catch (Exception $e) {
      $status = 500;
      $rpta = json_encode(
        [
          'tipo_mensaje' => 'error',
          'mensaje' => [
  					'No se ha podido listar los distritos de la provincia',
  					$e->getMessage()
  				]
        ]
      );
    }
    return $response->withStatus($status)->write($rpta);
  }

  public function buscar($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $nombre = $request->getQueryParam('nombre');
    try {
      $rs = Model::factory('VWDistritoProvinciaDepartamento', 'ubicaciones')
    		->select('id')
    		->select('nombre')
    		->where_like('nombre', $nombre . '%')
    		->limit(10)
    		->find_array();
      $rpta = json_encode($rs);
    }catch (Exception $e) {
      $status = 500;
      $rpta = json_encode(
        [
          'tipo_mensaje' => 'error',
          'mensaje' => [
  					'No se ha podido buscar las coincidencias de nombres de distritos',
  					$e->getMessage()
  				]
        ]
      );
    }
    return $response->withStatus($status)->write($rpta);
  }

  public function nombre($request, $response, $args) {
    $rpta = '';
    $status = 200;
    $distrito_id = $args['distrito_id'];
    try {
      $rs = Model::factory('VWDistritoProvinciaDepartamento', 'ubicaciones')
  			->select('nombre')
  			->where('id', $distrito_id)
  			->find_one()
  			->as_array();
  		$rpta = $rs['nombre'];
    }catch (Exception $e) {
      $status = 500;
      $rpta = json_encode(
        [
          'tipo_mensaje' => 'error',
          'mensaje' => [
            'No se ha podido listar los distritos de la provincia',
            $e->getMessage()
          ]
        ]
      );
    }
    return $response->withStatus($status)->write($rpta);
  }
}

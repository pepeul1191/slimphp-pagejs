<?php

namespace Controller;
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

  public function guardar($request, $response, $args) {
    $data = json_decode($request->getParam('data'));
    $nuevos = $data->{'nuevos'};
    $editados = $data->{'editados'};
    $eliminados = $data->{'eliminados'};
    $provincia_id = $data->{'extra'}->{'provincia_id'};
    $rpta = []; $array_nuevos = [];
    $status = 200;
    ORM::get_db('ubicaciones')->beginTransaction();
    try {
      if(count($nuevos) > 0){
        foreach ($nuevos as &$nuevo) {
          $distrito = Model::factory('Distrito', 'ubicaciones')->create();
          $distrito->nombre = $nuevo->{'nombre'};
          $distrito->provincia_id = $provincia_id;
          $distrito->save();
          $temp = [];
          $temp['temporal'] = $nuevo->{'id'};
          $temp['nuevo_id'] = $distrito->id;
          array_push( $array_nuevos, $temp );
        }
      }
      if(count($editados) > 0){
        foreach ($editados as &$editado) {
          $distrito = Model::factory('Distrito', 'ubicaciones')->find_one($editado->{'id'});
          $distrito->nombre = $editado->{'nombre'};
          $distrito->save();
        }
      }
      if(count($eliminados) > 0){
        foreach ($eliminados as &$eliminado) {
          $distrito = Model::factory('Distrito', 'ubicaciones')->find_one($eliminado);
          $distrito->delete();
        }
      }
      $rpta['tipo_mensaje'] = 'success';
      $rpta['mensaje'] = [
        'Se ha registrado los cambios en los distritos',
        $array_nuevos
      ];
      ORM::get_db('ubicaciones')->commit();
    }catch (Exception $e) {
      $status = 500;
      $rpta['tipo_mensaje'] = 'error';
      $rpta['mensaje'] = [
        'Se ha producido un error en guardar la tabla de distritos',
        $e->getMessage()
      ];
      ORM::get_db('ubicaciones')->rollBack();
    }
    return $response->withStatus($status)->write(json_encode($rpta));
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

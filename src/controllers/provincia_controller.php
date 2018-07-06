<?php

require_once 'src/models/provincia.php';

class ProvinciaController extends Controller
{
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

  public function guardar($request, $response, $args) {
    $data = json_decode($request->getParam('data'));
    $nuevos = $data->{'nuevos'};
    $editados = $data->{'editados'};
    $eliminados = $data->{'eliminados'};
    $departamento_id = $data->{'extra'}->{'departamento_id'};
    $rpta = []; $array_nuevos = [];
    $status = 200;
    ORM::get_db('ubicaciones')->beginTransaction();
    try {
      if(count($nuevos) > 0){
        foreach ($nuevos as &$nuevo) {
          $provincia = Model::factory('Provincia', 'ubicaciones')->create();
          $provincia->nombre = $nuevo->{'nombre'};
          $provincia->departamento_id = $departamento_id;
          $provincia->save();
          $temp = [];
          $temp['temporal'] = $nuevo->{'id'};
          $temp['nuevo_id'] = $provincia->id;
          array_push( $array_nuevos, $temp );
        }
      }
      if(count($editados) > 0){
        foreach ($editados as &$editado) {
          $provincia = Model::factory('Provincia', 'ubicaciones')->find_one($editado->{'id'});
          $provincia->nombre = $editado->{'nombre'};
          $provincia->save();
        }
      }
      if(count($eliminados) > 0){
        foreach ($eliminados as &$eliminado) {
          $provincia = Model::factory('Provincia', 'ubicaciones')->find_one($eliminado);
          $provincia->delete();
        }
      }
      $rpta['tipo_mensaje'] = 'success';
      $rpta['mensaje'] = [
        'Se ha registrado los cambios en las provincias',
        $array_nuevos
      ];
      ORM::get_db('ubicaciones')->commit();
    }catch (Exception $e) {
      $status = 500;
      $rpta['tipo_mensaje'] = 'error';
      $rpta['mensaje'] = [
        'Se ha producido un error en guardar la tabla de provincias',
        $e->getMessage()
      ];
      ORM::get_db('ubicaciones')->rollBack();
    }
    return $response->withStatus($status)->write(json_encode($rpta));
  }
}

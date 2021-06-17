<?php

namespace Controller;

class DepartamentoController extends \Configs\Controller
{
  public function listar($request, $response, $args) {
    $rpta = '';
    $status = 200;
    try {
      $rs = \Model::factory('\Models\Departamento', 'ubicaciones')
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

  public function guardar($request, $response, $args) {
    $data = json_decode($request->getParam('data'));
    $nuevos = $data->{'nuevos'};
    $editados = $data->{'editados'};
    $eliminados = $data->{'eliminados'};
    $rpta = []; $array_nuevos = [];
    $status = 200;
    \ORM::get_db('ubicaciones')->beginTransaction();
    try {
      if(count($nuevos) > 0){
        foreach ($nuevos as &$nuevo) {
          $departamento = \Model::factory('\Models\Departamento', 'ubicaciones')->create();
          $departamento->nombre = $nuevo->{'nombre'};
          $departamento->save();
          $temp = [];
          $temp['temporal'] = $nuevo->{'id'};
          $temp['nuevo_id'] = $departamento->id;
          array_push( $array_nuevos, $temp );
        }
      }
      if(count($editados) > 0){
        foreach ($editados as &$editado) {
          $departamento = \Model::factory('\Models\Departamento', 'ubicaciones')->find_one($editado->{'id'});
          $departamento->nombre = $editado->{'nombre'};
          $departamento->save();
        }
      }
      if(count($eliminados) > 0){
        foreach ($eliminados as &$eliminado) {
          $departamento = \Model::factory('\Models\Departamento', 'ubicaciones')->find_one($eliminado);
          $departamento->delete();
        }
      }
      $rpta['tipo_mensaje'] = 'success';
      $rpta['mensaje'] = [
        'Se ha registrado los cambios en los departamentos',
        $array_nuevos
      ];
      \ORM::get_db('ubicaciones')->commit();
    }catch (Exception $e) {
      $status = 500;
      $rpta['tipo_mensaje'] = 'error';
      $rpta['mensaje'] = [
        'Se ha producido un error en guardar la tabla de departamentos',
        $e->getMessage()
      ];
      \ORM::get_db('ubicaciones')->rollBack();
    }
    return $response->withStatus($status)->write(json_encode($rpta));
  }
}

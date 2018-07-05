<?php

require_once 'src/models/departamento.php';

class DepartamentoController
{
  public function listar($request, $response, $args) {
    $rs = Model::factory('Departamento', 'ubicaciones')
    	->select('id')
    	->select('nombre')
    	->find_array();
    return json_encode($rs);
  }
}

<?php

namespace Controller;

class StudentController extends \Configs\Controller
{
  public function check($request, $response, $args) {
    $rpta = '';
    $status = 200;
    try {
      $event_id = $request->getQueryParam('event_id');
      $dni = $request->getQueryParam('dni');
      $code = $request->getQueryParam('code');
      $grade = $request->getQueryParam('grade');
      $query = '?event_id=' . $event_id . '&dni=' . $dni;
      if($grade != null){$query = $query . '&grade=' . $grade;}
      if($code != null){$query = $query . '&code=' . $code;}
      $url = $this->constants['service_url'] . 'api/pdf/generate' . $query;
      $headers = array(
        $this->constants['admin']['key'] => $this->constants['admin']['value'],
      );
      $rs = \Unirest\Request::get($url, $headers);
      $status = $rs->{'code'};
      if($status == 200){
        $response = $response->withHeader('Content-Type', 'application/pdf');
      }
      $rpta = $rs->{'raw_body'};
    }catch (Exception $e) {
      $status = 500;
      $rpta = json_encode(
        [
          'No se ha podido listar los ponentes',
  				$e->getMessage()
        ]
      );
    }
    return $response->withStatus($status)->write($rpta);
  }
}

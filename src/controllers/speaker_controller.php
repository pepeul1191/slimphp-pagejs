<?php

namespace Controller;

class SpeakerController extends \Configs\Controller
{
  public function randomList($request, $response, $args) {
    $rpta = '';
    $status = 200;
    try {
      $number = $request->getQueryParam('number');
      $url = $this->constants['service_url'] . 'admin/speaker/random-list?number=' . $number;
      $rs = \Unirest\Request::get($url);
      $rpta = $rs->{'raw_body'};
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

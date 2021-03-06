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
          'No se ha podido listar los ponentes',
  				$e->getMessage()
        ]
      );
    }
    return $response->withStatus($status)->write($rpta);
  }
}

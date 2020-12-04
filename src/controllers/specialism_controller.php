<?php

namespace Controller;

class SpecialismController extends \Configs\Controller
{
  public function list($request, $response, $args) {
    $rpta = '';
    $status = 200;
    try {
      $number = $request->getQueryParam('number');
      $url = $this->constants['service_url'] . 'admin/specialism/list';
      $rs = \Unirest\Request::get($url);
      $rpta = $rs->{'raw_body'};
    }catch (Exception $e) {
      $status = 500;
      $rpta = json_encode(
        [
          'No se ha podido listar las espcialidades',
  				$e->getMessage()
        ]
      );
    }
    return $response->withStatus($status)->write($rpta);
  }
}

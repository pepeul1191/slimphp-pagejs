<?php

namespace Controller;

class EventController extends \Configs\Controller
{
  public function recentList($request, $response, $args) {
    $rpta = '';
    $status = 200;
    try {
      $url = $this->constants['service_url'] . 'admin/event/recent-list';
      $rs = \Unirest\Request::get($url);
      $rpta = $rs->{'raw_body'};
    }catch (Exception $e) {
      $status = 500;
      $rpta = json_encode(
        [
          'No se ha podido listar los eventos',
  				$e->getMessage()
        ]
      );
    }
    return $response->withStatus($status)->write($rpta);
  }
}

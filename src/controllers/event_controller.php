<?php

namespace Controller;

class EventController extends \Configs\Controller
{
  public function recentList($request, $response, $args) {
    $rpta = '';
    $status = 200;
    try {
      $url = $this->constants['service_url'] . 'api/event/recent-list';
      $headers = array(
        $this->constants['admin']['key'] => $this->constants['admin']['value'],
      );
      $params = array();
      $rs = \Unirest\Request::get($url, $headers, $params);
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

  public function search($request, $response, $args){
    $rpta = '';
    $status = 200;
    try {
      $specialism_id = $request->getQueryParam('specialism_id');
      $page = $request->getQueryParam('page');
      $step = $request->getQueryParam('step');
      $date = $request->getQueryParam('date');
      $event_type_id = $request->getQueryParam('event_type_id');
      if($date == 'past'){
        $date = 'init_date<CURDATE()';
      }else{
        $date = 'init_date>CURDATE()';
      }
      $url = $this->constants['service_url'] . 'api/event/search';
      $headers = array(
        $this->constants['admin']['key'] => $this->constants['admin']['value'],
      );
      $params = array(
        'specialism_id' => $specialism_id,
        'page' => $page,
        'step' => $step,
        'query_date' => $date,
        'event_type_id' => $event_type_id,
      );
      $rs = \Unirest\Request::get($url, $headers, $params);
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

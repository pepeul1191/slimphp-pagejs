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

  public function search($request, $response, $args){
    $rpta = '';
    $status = 200;
    try {
      $specialism_id = $request->getQueryParam('specialism_id');
      $page = $request->getQueryParam('page');
      $step = $request->getQueryParam('step');
      $date = $request->getQueryParam('date');
      if($date == 'past'){
        $date = 'init_date<CURDATE()';
      }else{
        $date = 'init_date>CURDATE()';
      }
      $url = $this->constants['service_url'] . 'admin/event/search?' .
          'specialism_id=' . $specialism_id . '&' .
          'page=' . $page . '&' .
          'step=' . $step . '&' .
          'query_date=' . $date;
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

<?php

namespace Controller;

use Unirest\Request;

class EventController extends \Configs\Controller
{
  public function list($request, $response, $args)
  {
    // params
    $student_id = $_SESSION['student_id'];
    // unirest
    $url = $this->constants['admin']['url'] . 'api/event/student';
    $headers = array(
      $this->constants['admin']['key'] => $this->constants['admin']['value'],
    );
    $params = array(
      'student_id' => $student_id,
    );
    $response_admin = Request::get($url, $headers, $params);
    // response
    $resp = null;
    $status = 500;
    if($response_admin->code == 200){
      $resp = $response_admin->raw_body;
      $status = 200;
    }else{
      $resp = 'ups, ocurrió un error en listar los eventos del alumno';
    }
    return $response->withStatus($status)->write($resp);
  }

  public function studentDocuments($request, $response, $args)
  {
    // params
    $event_id = $request->getParam('event_id');
    $student_id = $_SESSION['student_id'];
    // unirest
    $url = $this->constants['admin']['url'] . 'api/event/document/student';
    $headers = array(
      $this->constants['admin']['key'] => $this->constants['admin']['value'],
    );
    $params = array(
      'student_id' => $student_id,
      'event_id' => $event_id,
    );
    $response_admin = Request::get($url, $headers, $params);
    // response
    $resp = null;
    $status = 500;
    if($response_admin->code == 200){
      $resp = $response_admin->raw_body;
      $status = 200;
    }else{
      $resp = 'ups, ocurrió un error en listar los documentos del evento';
    }
    return $response->withStatus($status)->write($resp);
  }

  public function studentVideos($request, $response, $args)
  {
    // params
    $event_id = $request->getParam('event_id');
    $student_id = $_SESSION['student_id'];
    // unirest
    $url = $this->constants['admin']['url'] . 'api/event/video/student';
    $headers = array(
      $this->constants['admin']['key'] => $this->constants['admin']['value'],
    );
    $params = array(
      'student_id' => $student_id,
      'event_id' => $event_id,
    );
    $response_admin = Request::get($url, $headers, $params);
    // response
    $resp = null;
    $status = 500;
    if($response_admin->code == 200){
      $resp = $response_admin->raw_body;
      $status = 200;
    }else{
      $resp = 'ups, ocurrió un error en listar los videos del evento';
    }
    return $response->withStatus($status)->write($resp);
  }

  public function recentList($request, $response, $args) {
    $resp = '';
    $status = 200;
    try {
      $url = $this->constants['admin']['url'] . 'api/event/recent';
      $headers = array(
        $this->constants['admin']['key'] => $this->constants['admin']['value'],
      );
      $params = array();
      $response_admin = Request::get($url, $headers, $params);
      $resp = $response_admin->{'raw_body'};
    }catch (Exception $e) {
      $status = 500;
      $resp = json_encode(
        [
          'No se ha podido listar los eventos',
  				$e->getMessage()
        ]
      );
    }
    return $response->withStatus($status)->write($resp);
  }

}

?>

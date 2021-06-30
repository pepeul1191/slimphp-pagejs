<?php

namespace Controller;

use Unirest\Request;

class DocumentController extends \Configs\Controller
{
  public function get($request, $response, $args)
  {
    $status = 200;
    // params
    $student_id = $_SESSION['student_id'];
    $event_id = $request->getParam('event_id');
    $document_id = $request->getParam('document_id');
    // unirest validate access to document
    $url = $this->constants['admin']['url'] . 'api/event/document/get';
    $headers = array(
      $this->constants['admin']['key'] => $this->constants['admin']['value'],
    );
    $params = array(
      'student_id' => $student_id,
      'event_id' => $event_id,
      'document_id' => $document_id,
    );
    $response_admin = Request::get($url, $headers, $params);
    if($response_admin->code != 200){
      $status = 404;
      $resp = 'no existe el documento';
    }else{
      $this->load_helper('document');
      $extension = get_type_extension($response_admin->body);
      // unirest get document
      $document_url = $response_admin->body;
      $url = $this->constants['admin']['static_url'] . $document_url;
      $headers = array(
        $this->constants['admin']['key'] => $this->constants['admin']['value'],
      );
      $params = array();
      $response_admin = Request::get($url, $headers, $params);
      $response = $response->withHeader('Content-Type', $extension);
      $resp = $response_admin->body;
    }
    // response
    return $response->withStatus($status)->write($resp);
  }
}

?>
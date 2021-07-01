<?php

namespace Controller;

use Unirest\Request;

class DistrictController extends \Configs\Controller
{
  public function search($request, $response, $args)
  {
    $status = 200;
    // params
    $name = $request->getParam('name');
    // unirest validate access to document
    $url = $this->constants['admin']['url'] . 'admin/district/search';
    $headers = array(
      $this->constants['admin']['key'] => $this->constants['admin']['value'],
    );
    $params = array(
      'name' => $name,
    );
    $response_admin = Request::get($url, $headers, $params);
    if($response_admin->code != 200){
      $status = 404;
      $resp = 'no existe el distrito';
    }else{
      $resp = $response_admin->raw_body;
    }
    // response
    return $response->withStatus($status)->write($resp);
  }
}

?>
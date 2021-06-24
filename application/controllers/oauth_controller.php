<?php

namespace Controller;

use Unirest\Request;

class OAuthController extends \Configs\Controller
{
  public function googleCallback($request, $response, $args){
    $code = $request->getParam('code');
    $url = 'https://oauth2.googleapis.com/token';
    // oauth - token
    $headers = array();
    $params = array(
      'client_id' => $this->env['OAUTH_CLIENT_ID'],
      'client_secret' => $this->env['OAUTH_SECRET'],
      'code' => $code,
      'grant_type' => 'authorization_code',
      'redirect_uri' => $this->constants['redirect_url']['google'],
    );
    $response_oauth = Request::post($url, $headers, $params);
    if($response_oauth->code == 200){
      // oauth user info
      $response_oauth = json_decode($response_oauth->raw_body);
      $url = 'https://www.googleapis.com/oauth2/v1/userinfo';
      $headers = array();
      $access_token = $response_oauth->access_token;
      $params = array(
        'access_token' => $access_token,
      );
      $response_oauth = Request::get($url, $headers, $params);
      if($response_oauth->code == 200){
        $response_oauth = json_decode($response_oauth->raw_body);
        // validate if email is registered in 'admin' system
        $url = $this->constants['admin']['url'] . 'api/student/check';
        $headers = array(
          $this->constants['admin']['key'] => $this->constants['admin']['value'],
        );
        $params = array(
          'email' => $response_oauth->email,
        );
        //var_dump($headers);var_dump($params);exit();
        $response_admin = Request::get($url, $headers, $params);
        if($response_admin->code == 200){
          $response_admin = json_decode($response_admin->raw_body);
          $_SESSION['student_id'] = $response_admin->id;
          $_SESSION['student_names'] = $response_admin->names;
          $_SESSION['student_last_names'] = $response_admin->last_names;
          $_SESSION['user_data'] = $response_oauth;
          $_SESSION['access_token'] = $access_token;
          $_SESSION['user_nick'] = $response_oauth->name;
          $_SESSION['user_name'] = $response_oauth->name;
          $_SESSION['user_img'] = $response_oauth->picture;
          $_SESSION['user_email'] = $response_oauth->email;
          $_SESSION['status'] = 'active';
          $_SESSION['app'] = 'Google';
          $_SESSION['logout_url'] = 'https://accounts.google.com/Logout?continue=https://appengine.google.com/_ah/logout?continue=' . $this->constants['base_url'] . 'sign_out';
          header('Location: ' . $this->constants['base_url']);
          exit();
        }elseif($response_admin->code == 501){
          header('Location: ' . $this->constants['base_url'] . 'login?message=error-auth-access');
          exit(); 
        }else{
          header('Location: ' . $this->constants['base_url'] . 'login?message=error-auth');
          exit();  
        }
      }else{
        header('Location: ' . $this->constants['base_url'] . 'login?message=error-oauth');
        exit();  
      }
      
    }else{
      header('Location: ' . $this->constants['base_url'] . 'login?message=error-ouath');
      exit();
    }
  }
}

?>

<?php

if ( ! function_exists('get_type_extension'))
{
  function get_type_extension($url_document){
    $resp = null;
    $extension = array_pop(explode('.', $url_document));
    switch($extension){
      case 'pdf': 
        $resp = 'application/pdf';
        break;
      case 'doc': 
        $resp = 'application/msword';
        break;
      case 'docx': 
        $resp = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        break;
      case 'ppt': 
        $resp = 'application/vnd.ms-powerpoint';
        break;
      case 'pptx': 
        $resp = 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
        break;  
      default:
        $resp = 'application/pdf';
        break;
    }
    return $resp;
  }
}

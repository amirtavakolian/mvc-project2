<?php
namespace app\core;

class request {

  private $uri; 
  private $method;
  private $userAgent;
  private $remoteAddress; 
  private $queryString;


  public function __construct()
  {
    $this->uri = explode("?", str_replace(env('REMOVE_FROM_URI'), "", $_SERVER['REQUEST_URI']))[0];
    $this->method = $_SERVER['REQUEST_METHOD'];
    $this->userAgent = $_SERVER['HTTP_USER_AGENT'];
    $this->remoteAddress = $_SERVER['REMOTE_ADDR'];
    $this->queryString = $_SERVER['QUERY_STRING'];
  }


  
  public function getUri(){
    return $this->uri;
  }

  public function getMethod(){
    return $this->method;
  }

  public function getUserAgent(){
    return $this->userAgent;
  }

  public function getRemoteAddress(){
    return $this->remoteAddress;
  }
  
  public function getQueryString(){
    return $this->queryString;
  }
  

}
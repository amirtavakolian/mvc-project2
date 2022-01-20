<?php
namespace app\core;


class routes{

  private static $routesTable = [];

   
  public static function add($route, $target, $method=["get"]){
    
    if(!is_array($method)){
      $method = [$method];
    }

    $route = routes::routeToRegularExprestion($route);
       
    if(!is_array($target)){
  
        $target = ["target"=>$target, "method"=>$method];
        routes::$routesTable[$route] = $target;
    }else{
        
        $target["method"] = $method;
        routes::$routesTable[$route] = $target;
    }
  }

  private static function routeToRegularExprestion($route)
  {
    $route = preg_replace("/\//", "\\/", $route);
    $route = preg_replace("/\{([a-z]+)\}/", '(?<\1>[a-z0-9]+)', $route);
    $route = "/^". $route ."\/?$/";
    return $route;
  }


  public static function getRoutes(){
    return routes::$routesTable;
  }


  public static function get($route,$target){
    routes::add($route, $target, "get");
  }

  public static function post($route,$target){
    routes::add($route, $target, "post");
  }

 

}
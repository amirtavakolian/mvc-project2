<?php
namespace app\core;


class router{

    private $table = [];
    private $parameters = [];
    private $target = [];
    private $request;
    private $regularRoute;
    private $namespace = ""; 

    const MAIN_NAMESPACE = "app\\controller\\";


    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->table = routes::getRoutes();
    }
    

    public function start(){

        if (!$this->routeExist()){
            view("pages.404");
            die();
        }
        
        if (!$this->checkRequestMethod()){
            view("pages.405");
            die();
        }

        list($controller, $action) = $this->checkTarget();   

        $obj = new $controller();
        $obj->$action($this->parameters);
        
    }


    private function routeExist(){

        foreach ($this->table as $key=>$value){
            if(preg_match($key, $this->request->getUri(), $matches)){
                
                $this->regularRoute = $key;
                $this->checkCallable($value);
                $this->target = $value;

                foreach($matches as $matchesKey=>$matchesValue){
                    if(is_string($matchesKey)){
                        $this->parameters[$matchesKey] = $matchesValue;
                    }
                }
                return true;
            }
        }
        return false;
    }
    

    private function checkRequestMethod(){

        if(!in_array($this->request->getMethod(), $this->table[$this->regularRoute]["method"])){
            return false;
        }
        return true;
    }
    

    private function checkTarget(){

        list($controller, $action)  = $this->getControllerAction();
        $namespace = $this->getNamespace();

        $controller = router::MAIN_NAMESPACE.$namespace.$controller;

        if(!class_exists($controller)){
            die("Controller Not Found");
        }

        if(!method_exists($controller, $action)){
            die("Action Not Found");
        }
        return [$controller, $action];
    }

   
    private function checkCallable($value){
        if(is_callable($value["target"])){            
            $value["target"]();
            die();
        }
    }


    public function addRoute($route, $target){
        $route = preg_replace("/\//", "\\/", $route);
        $route = preg_replace("/\{([a-z]+)\}/", '(?<\1>[a-z0-9]+)', $route);
        $route = "/^". $route ."\/?$/";

        if(!is_array($target)){
            $this->table[$route] = ["target"=>$target];
        }else{
            $this->table[$route] = $target;
        }
    }


    public function getRoutes(){
        return $this->table;
    }
    

    private function getControllerAction(){
        list($controller, $action) = explode("@", $this->target['target']);       
        return [$controller, $action];
    }

    private function getNamespace(){
        if(array_key_exists("namespace", $this->target)){
            return $this->target['namespace'];
        }
        return "";
    }
} 
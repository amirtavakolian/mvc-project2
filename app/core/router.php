<?php
namespace app\core;


class router{

    private $table = [];
    private $request;
    private $namespace = ""; 

    const MAIN_NAMESPACE = "app\\controller\\";


    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    
    public function start(){

        if (!$this->routeExist()){
            view("pages.404");
            die();
        }

        list($controller, $action) = $this->checkTarget();   

        $obj = new $controller();
        $obj->$action();
    }


    private function checkTarget(){

        $target = $this->getTarget();

        $this->defineNamespace();    
        
        list($controller, $action)  = $this->getControllerAction($target);

        if(!class_exists($controller)){
            die("Controller Not Found");
        }

        if(!method_exists($controller, $action)){
            die("Action Not Found");
        }

        return [$controller, $action];
    }



    public function addRoute($route, $target){

        if(!is_array($target)){
            $this->table[$route] = ["target"=>$target];
        }else{
            $this->table[$route] = $target;
        }
    }


    private function routeExist(){
        return array_key_exists($this->request->getUri(), $this->table);
    }

    public function getRoutes(){
        return $this->table;
    }
    
    private function getTarget(){
        return $this->table[$this->request->getUri()]["target"];
    }


    private function defineNamespace(){

        if (array_key_exists("namespace",$this->table[$this->request->getUri()])){
            $this->namespace = $this->table[$this->request->getUri()]["namespace"];
        }
    }


    private function getControllerAction($target){

        list($controller, $action) = explode("@", $target);       
        $controller = router::MAIN_NAMESPACE . $this->namespace . $controller;
        return [$controller, $action];
    }
}
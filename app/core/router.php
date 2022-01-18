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

        die();

        list($controller, $action) = $this->checkTarget();   

        $obj = new $controller();
        $obj->$action();
    }


    private function checkTarget(){

        $target = $this->getTarget();

        var_dump($target);

        die();

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


        $route = preg_replace("/\//", "\\/", $route);
        
        $route = preg_replace("/\{[a-z]+\}/", "([a-z]+)", $route);



        echo $route;

        if(!is_array($target)){
            $this->table[$route] = ["target"=>$target];
        }else{
            $this->table[$route] = $target;
        }
    }


    private function routeExist(){
        foreach ($this->table as $key=>$value){      
            if(preg_match("/^". $key ."\/?$/", $this->request->getUri())){
                return true;
            }
        }
        return false;
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
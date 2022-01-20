<?php
use app\core\routes;


routes::get("/admin", ["target"=>"AdminController@index", "namespace"=>"panel\\admin\\"]);
routes::get("/amir", "AmirController@index");

routes::get("/course/{name}/part/{id}", "CourseController@index"); 
routes::post("/amircall", function(){ echo "salam daii"; });

routes::add("/panel/{id}", "PanelController@index"); 
routes::add("/", "HomeController@index"); 



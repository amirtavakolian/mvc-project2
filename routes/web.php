<?php

$router->addRoute("/admin", ["target"=>"AdminController@index", "namespace"=>"panel\\admin\\"]);
$router->addRoute("/amir", "AmirController@index");

$router->addRoute("/course/{name}/part/{id}", "CourseController@index");




<?php

define("BASE_PATH", dirname(__DIR__)."\\");
const VIEW_PATH = "resources\\views\\";


require dirname(__DIR__) . "\\vendor\\autoload.php";
require dirname(__DIR__) . "\\helper\\helper.php";


$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$request = new app\core\request();
$router = new app\core\router($request);


require dirname(__DIR__) . "\\routes\\web.php";


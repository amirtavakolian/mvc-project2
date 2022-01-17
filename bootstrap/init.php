<?php

require dirname(__DIR__) . "\\vendor\\autoload.php";
require dirname(__DIR__) . "\\helper\\env.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();


$uri = str_replace(env('REMOVE_FROM_URI'), "", $_SERVER['REQUEST_URI']);





echo "<h3><pre>";
print_r($_SERVER);
echo "</pre>";
<?php
require dirname(__DIR__) . "\\bootstrap\\init.php";


echo '<pre>';
  print_r($router->getRoutes());
echo '</pre>';



 $router->start();
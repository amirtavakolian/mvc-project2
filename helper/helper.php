<?php

function env($key){

    return $_ENV[$key];
}


function view($fileName, $data=[]){
    
    $file = str_replace(".", "\\", $fileName);
    $file = BASE_PATH.VIEW_PATH.$file.".php";

    if (!file_exists($file)){
        die("<br>File not exist");
    }
    
    include ($file);

}


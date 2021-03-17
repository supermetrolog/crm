<?php

$dir    = $_SERVER['DOCUMENT_ROOT'].'/export/maps-tmp/';  
$files = scandir($dir);

foreach($files as $file){
    if(is_file($dir.$file)){
        unlink($dir.$file);
    }
}
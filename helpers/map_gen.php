<?php


//header ("Content-type: image/jpg");




$test =  file_get_contents('https://static-maps.yandex.ru/1.x/?ll=35.620070,55.753630&size=262,450&z=13&l=map&pt=35.620070,55.753630,vkbkm');

file_put_contents('map.png',$test);

//echo $test;


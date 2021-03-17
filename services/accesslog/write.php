<?php

//смотрим что уже есть в файлах
$data = json_decode(file_get_contents('current.json'),true);


if (count($data) > 10000 ) {
    $data = [];
}
//получаем адрес
//$userAddr = $_SERVER['REMOTE_ADDR'];
$userAddr = $_GET['ip'];

//добавляем в начало списка
array_unshift($data, ['ip'=>$userAddr,'time'=>time()]);


//кодируем
$dataNewJson = json_encode($data);



//сохраняем
file_put_contents('current.json',$dataNewJson);
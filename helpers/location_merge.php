<?php

/*

include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';

include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';

//мотрим среди всех центральных городов
$sql_towns_central = $pdo->prepare("SELECT * FROM l_towns_central ");
$sql_towns_central->execute();

while($item = $sql_towns_central->fetch(PDO::FETCH_LAZY)){

    //название центрального города
    $name = $item->title;

    echo $name.'<br>';

    //ищем это название в таблице ГОРОДОВ
    $sql_towns = $pdo->prepare("SELECT COUNT(id) as num FROM l_towns WHERE title='$name' ");
    $sql_towns->execute();
    $num = $sql_towns->fetch(PDO::FETCH_LAZY);

    //Если нету то дописываем в таблицу городов
    if($num['num'] < 1){
        $post = new Post();
        $post->getTable('l_towns');
        $post->createLine(['title'],[$name]);
    }

}


//смотрим для всех локаций
$sql_locations = $pdo->prepare("SELECT * FROM l_locations ");
$sql_locations->execute();

while($item = $sql_locations->fetch(PDO::FETCH_LAZY)){

    echo $item->id.'<br>';

    //объект локации
    $location = new Location($item->id);

    //смотрим название ЦЕНТРАЛЬНОГО ГОРОДА у локации
    $town_central = new Post($item->town_central);
    $town_central->getTable('l_towns_central');
    $town_central_name = $town_central->getField('title');

    //смотрим в таблице ГОРОДОВ id по названию центрального
    $sql_towns = $pdo->prepare("SELECT id FROM l_towns WHERE title='$town_central_name' ");
    $sql_towns->execute();
    $town_info = $sql_towns->fetch(PDO::FETCH_LAZY);

    $location->updateField('town_central',$town_info->id);

}



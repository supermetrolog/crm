<?php

//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

//$search = $_POST['search'];

if($_POST['request']){
    $filters_arr = json_decode($_POST['request']);

    $search = $filters_arr->search;
}else{

    $search = 'арбатс';
}





$arr_tables = [
    //'ID'=>'c_)industry',
    'Регион'=>['l_regions','regions'],
    'Город'=>['l_towns','towns'],
    'Район'=>['l_districts','districts'],
    'Округ'=>['l_districts_moscow','districts_moscow'],
    'Направления'=>['l_directions','directions'],
    'Метро'=>['l_metros','metros'],
    'Шоссе МО'=>['l_highways','highways'],
    'Шоссе Москвы'=>['l_highways_moscow','highways_moscow'],
];

$arr_response = [];


foreach ($arr_tables as $key=>$value){
    $arr = [];
    $sql = $pdo->prepare("SELECT * FROM $value[0] WHERE title LIKE '%$search%'   ORDER BY title DESC LIMIT 5");
    $sql->execute();
    while($item = $sql->fetch(PDO::FETCH_LAZY)){
        $arr['title'] = $key;
        $arr['eng'] = $item->title_eng;
        $arr['type'] = $value[1];
        $arr['name'] = $item->title;
    }
    if($arr){
        $arr_response[] = $arr;
    }


}

echo json_encode($arr_response, JSON_UNESCAPED_UNICODE) ;

<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';


if($_GET['page']){
    $page = $_GET['page'];
}else{
    $page = 1;
    $sql = $pdo->prepare("TRUNCATE TABLE c_industry_complex  ");
    $sql->execute();
}


$per_page = 1000;

$from = ($page - 1)*$per_page;

$star_time = time();

$sql = $pdo->prepare("SELECT * FROM c_industry WHERE deleted!=1 AND complex_id=0 ORDER BY id ASC ");
//$sql = $pdo->prepare("SELECT * FROM c_industry WHERE deleted!=1 AND id=10248 ORDER BY id ASC LIMIT $from, $per_page");
$sql->execute();

/*
$arr_fields = [
    'title',
    'address',
    'location_id',

    'from_mkad',
    'mkad_ttk_between',

    'from_metro',
    'from_metro_value',

    'from_station',
    'from_station_value',

    'from_busstop',
    'from_busstop_value',

    'photo',

    'publ_time',
    'last_update',

    'area_field_full',
    'land_length',
    'land_width',
    'own_type_land',
    'cadastral_number_land',
    'land_category',
    'landscape_type',

    'land_use_restrictions',

    'land_use_restrictions',

    'land_use_restrictions',
];
*/

while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
    $fields = [];
    $values = [];

    $object = new Building($item->id);

    $complex = new Complex();

    foreach ($item as $key=>$value){
        if($key != 'id' && $complex->hasField($key)){
            $fields[] = $key;
            $values[] = $value;
        }
    }

    $complex_id = $complex->createLine($fields, $values);

    $object->updateField('complex_id',$complex_id);

}

$next = $page+1;


//header('Location: https://pennylane.pro/helpers/complex_create.php?page='.$next);
echo time() - $star_time;
echo 'сек';
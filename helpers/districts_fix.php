<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 30.07.2020
 * Time: 15:21
 */


/*  
include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';

$sql = $pdo->prepare("SELECT * FROM l_locations ");
$sql->execute();

while ($item = $sql->fetch(PDO::FETCH_LAZY)) {

    if($item->district && $item->district_type){
        $district = new Post($item->district);
        $district->getTable('l_districts');
        $district->updateField('district_type',$item->district_type);

        $district_former = new Post($item->district_former);
        $district_former->getTable('l_districts_former');
        $district_former->updateField('district_type',$item->district_type);
    }

}
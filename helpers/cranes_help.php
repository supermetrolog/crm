<?php
/**
 * Created by PhpStorm.
 * User: timondecathlon
 * Date: 06.08.20
 * Time: 12:09
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';

$sql = "SELECT DISTINCT(i.id) FROM c_industry i LEFT JOIN c_industry_blocks b ON i.id=b.object_id ";

$arr_fields = [
    'b.cranes_overhead',
    'b.cranes_cathead',
    'b.telphers',
    'b.elevators',
    'i.elevators',
    'i.cranes_gantry',
    'i.cranes_railway',
];

$arr_values = [
    '1',
    '2',
    '3',
    '4',
    '5',
    '6',
    '7',
    '8',
    '9',
    '10',
];



$filter = ' WHERE ';

foreach ($arr_fields as $field) {
    $unit_line = '';
    foreach ($arr_values as $value) {
        $unit_line .= " $field LIKE '%$value%' OR ";
    }
    $filter .= $unit_line;
}

$sql .= $filter;

$sql  .= " b.cranes_runways=1 OR i.cranes_runways= 1";

echo $sql ;



/*

$sql = $pdo->prepare("SELECT * FROM l_locations ");
$sql->execute();

while ($item = $sql->fetch(PDO::FETCH_LAZY)) {



}



SELECT * FROM c_industry i LEFT JOIN c_industry_blocks b ON i.id=b.object_id  WHERE cranes_overhead LIKE '%%'
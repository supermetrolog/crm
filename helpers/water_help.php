<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';

$sql = $pdo->prepare("SELECT * FROM c_industry_complex");

$sql->execute();

while($item = $sql->fetch(PDO::FETCH_LAZY)){
    $obj = new Complex($item->id);
    $obj->updateField('water_type',json_encode([$item->water_type]));
}
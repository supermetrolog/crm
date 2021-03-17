<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';

$star_time = time();

$sql = $pdo->prepare("SELECT id FROM l_locations  ");
$sql->execute();

while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
    $object = new Location($item->id);
    $objects  = json_encode([$object->getField('direction_relevant')]);
    echo $owners.'<br>';
    $object->updateField('direction_relevant',$objects);
}




//header('Location: https://pennylane.pro/helpers/complex_create.php?page='.$next);
echo time() - $star_time;
echo 'сек';
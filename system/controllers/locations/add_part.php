<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$table = $_POST['table'];
$title = trim($_POST['title']);

if($title){
    if($town_type = $_POST['town_type']){
        $town_district = $_POST['town_district'];
        $sql = $pdo->prepare("SELECT COUNT(id) as num FROM $table WHERE title='$title' AND town_type=$town_type  AND  town_district=$town_district");
        $sql->execute();
        $item = $sql->fetch(PDO::FETCH_LAZY);
        if($item->num < 1){
            $sql = $pdo->prepare("INSERT INTO $table(title,town_type,town_district) VALUES('$title',$town_type,$town_district)");
            $sql->execute();
        }

    }else{
        $sql = $pdo->prepare("SELECT COUNT(id) as num FROM $table WHERE title='$title'");
        $sql->execute();
        $item = $sql->fetch(PDO::FETCH_LAZY);
        if($item->num < 1){
            $sql = $pdo->prepare("INSERT INTO $table(title) VALUES('$title')");
            $sql->execute();
        }

    }

}




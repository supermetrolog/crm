<?php

//var_dump($_POST);

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

$table_id = (int)$_POST['table_id'];

$title = $_POST['title'];

$post = new Post();
$post->getTable((new Table($table_id))->tableName());
$post->getPostByTitle($title);



if($post->id){
    $id = $post->id;
    $response = [$id,'Уже есть'];
}else{
    $id = $post->createLine(['title'],[$title]);
    $response = [$id,'Добавили'];
}



echo json_encode($response);
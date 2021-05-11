<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');


$sql = $pdo->prepare("SELECT * FROM  core_fields");
$sql->execute();

while($item = $sql->fetch(PDO::FETCH_LAZY)){


    $field = new  Field($item['id']);

    $temp = new Post(0);
    $temp->getTable('core_fields_templates');
    $temp->getPostByTitle($item['field_template']);

    $field->updateField('field_template_id', $temp->postId());
}

/*

$sql = $pdo->prepare("SELECT * FROM  core_pages");
$sql->execute();

while($item = $sql->fetch(PDO::FETCH_LAZY)){

    $new_grid = [];
    $grid = json_decode($item->grid_columns);

    $arr_page = [];
    $arr_page[] = ['page',$grid];

    $arr =[];
    $arr['main'] = $arr_page;

    $post = new Post($item->id);
    $post->getTable('core_pages');

    $post->updateField('grid_elements_test',json_encode($arr));
}



/*

$sql = $pdo->prepare("SELECT * FROM  core_tables");
$sql->execute();

while($item = $sql->fetch(PDO::FETCH_LAZY)){

    $new_grid = [];
    $grid = json_decode($item->grid_elements);


    $arr =[];
    $arr['main'] = $grid;

    $post = new Post($item->id);
    $post->getTable('core_tables');

    $post->updateField('grid_elements_test',json_encode($arr));
}

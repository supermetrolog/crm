<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 08.05.2018
 * Time: 14:13
 */
require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$post = new Post($_GET['id']);
$post->getTable($_GET['category']);

if($post->isActive()){
    $post->deactivate();
}else{
    $post->activate();
}
header("Location: ".$_SERVER['HTTP_REFERER']);
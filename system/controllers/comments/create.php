<?php
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');


$currComment = new Comment(0);
$com = $currComment->createUpdate();

if($_POST['ajax']){
    echo $com;
}else{
    header("Location: ".$_SERVER['HTTP_REFERER']);
}

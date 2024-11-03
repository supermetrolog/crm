<? include_once($_SERVER['DOCUMENT_ROOT'].'/classes/autoload.php');?>

<?php
$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$furl = parse_url($url);


var_dump($furl);
$id = $_GET['id'];
$table = $_GET['table'];

echo $id;
echo $table;

$post = new Post($id);
$post->getTable($table);



//var_dump($post->getLine());

$response = json_encode($post->getLine());

echo $response;


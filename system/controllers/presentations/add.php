<?
include_once ($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');
$logedUser = new Member($_COOKIE['member_id']);
$offer_data = json_decode($_GET['offer_id']);
//var_dump($offer_data);
$logedUser->setPresentations($offer_data);

//header("Location: ".$_SERVER['HTTP_REFERER']);
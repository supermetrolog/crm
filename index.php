<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
$memberId = $_COOKIE['member_id'] ?? null;

if($memberId == 999){
    include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
}

if($memberId == 141){
   echo 33333111222;
}

/*
if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, 'https://pennylane.pro/services/accesslog/write.php?ip=' . $_SERVER['REMOTE_ADDR']);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl);
    //echo $out;
    curl_close($curl);
}
*/

//if($_COOKIE['member_id'] == 9999){
    if(file_exists('block')){
        exit(0);
    }
//}

require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

($router = Bitkit\Core\Routing\Router::getInstance())->setURL();
$router->getWay();
$page = $router->getPage();



?>
<? require_once($_SERVER['DOCUMENT_ROOT'].'/components/header/index.php');?>
<div class='container'>
    <div class='container_slim' <?if($page->width()){?> style='max-width: <?=$page->width()?>px' <?}?>>
        <? if($page->canSee()){ //Проверяем разрешение на просмотр страницы?>
            <? include $_SERVER['DOCUMENT_ROOT'].'/templates/pages/index/index.php'?>
        <?}else{?>
            <? include $_SERVER['DOCUMENT_ROOT'].'/templates/errors/unavaliable/index.php'?>
        <?}?>
	</div>
</div>
<?if($logedUser->isAdmin() && $logedUser->member_id() == 141){require_once($_SERVER['DOCUMENT_ROOT'].'/components/constructor/index.php');}?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/components/footer/index.php');?>



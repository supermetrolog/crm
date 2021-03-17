<?php
ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$url = 'https://www.cian.ru/highways.xml';

//header("Content-type: text/xml");
if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl, CURLOPT_POST, true);
    //curl_setopt($curl, CURLOPT_POSTFIELDS, "login=feed_teamcadillac&password=1qazxsw2");
    $out = curl_exec($curl);
    //echo $out;
    curl_close($curl);
}
//var_dump($out);


$data = new SimpleXMLElement($out);

$test = ($data->location);
//$test = (array)($data);

$sql = $pdo->prepare("TRUNCATE TABLE l_highways_cian");
$sql->execute();

foreach($test as $elem){
    echo $elem->attributes()->id.' - '.$elem.'<br>' ;
    $id= $elem->attributes()->id;

    //$sql = $pdo->prepare("INSERT INTO l_highways_cian(`id`,`title`) VALUES('$id','$elem')");
    //$sql->execute();

    $highway = new Post();
    $highway->getTable('l_highways_cian');
    $highway->createLine(['id','title'],[$id,$elem]);

    //var_dump($elem);

}


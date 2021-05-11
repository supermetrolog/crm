<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$start = microtime(true);

$blocks_count = 0;
$objects_count = 0;


//Создает XML-строку и XML-документ при помощи DOM
$dom = new DomDocument('1.0');

//добавление корня - <books>
$feed = $dom->appendChild($dom->createElement('feed'));

//добавление элемента <$feed_version> в <$feed>
$feed_version = $feed->appendChild($dom->createElement('feed_version'));
$feed_version->appendChild($dom->createTextNode('2'));


$table = 'c_industry_offers_mix';


//всего

$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_realtor=1  AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 || type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО : '. $count['num'] .'шт. <br><br>';




//всего АРЕНДЫ

$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE (deal_type=1 OR deal_type=3 OR deal_type=4) AND ad_realtor=1  AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 || type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО АРЕНДЫ: '. $count['num'] .'шт. <br><br>';


//всего ПРОДАЖА

$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE deal_type=2 AND ad_realtor=1  AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 || type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО ПРОДАЖА: '. $count['num'] .'шт. <br><br>';



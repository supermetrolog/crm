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

echo '<b>Статистика выгрузки на Яндекс</b> <br><br><br>';


$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE (type_id=1 OR blocks_amount > 1) AND  deleted!='1' AND ad_yandex=1 AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND  test_only!=1  AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО : '. $count['num'] .'шт. <br><br>';


//--------------------------всего АРЕНДЫ
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE (deal_type=1 OR deal_type=3 OR deal_type=4) AND (type_id=1 OR blocks_amount > 1) AND  deleted!='1' AND ad_yandex=1 AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND  test_only!=1  AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО АРЕНДЫ: '. $count['num'] .'шт. <br><br>';

//-------------------------- АРЕНДЫ в Москве
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE region=6  AND (deal_type=1 OR deal_type=3 OR deal_type=4) AND (type_id=1 OR blocks_amount > 1) AND  deleted!='1' AND ad_yandex=1 AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND  test_only!=1  AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'АРЕНДЫ в Москве: '. $count['num'] .'шт. <br><br>';

//-------------------------- АРЕНДЫ в МО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE region=1  AND (deal_type=1 OR deal_type=3 OR deal_type=4) AND (type_id=1 OR blocks_amount > 1) AND  deleted!='1' AND ad_yandex=1 AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND  test_only!=1  AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'АРЕНДЫ в МО: '. $count['num'] .'шт. <br><br>';

//-------------------------- АРЕНДЫ в регионах
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE region NOT IN (1,6)  AND (deal_type=1 OR deal_type=3 OR deal_type=4) AND (type_id=1 OR blocks_amount > 1) AND  deleted!='1' AND ad_yandex=1 AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND  test_only!=1  AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'АРЕНДЫ в регионах: '. $count['num'] .'шт. <br><br>';


//--------------------------всего ПРОДАЖИ
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE deal_type=2 AND (type_id=1 OR blocks_amount > 1) AND  deleted!='1' AND ad_yandex=1 AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND  test_only!=1  AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО ПРОДАЖИ: '. $count['num'] .'шт. <br><br>';

//-------------------------- ПРОДАЖИ в Москве
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE  region=6  AND deal_type=2 AND (type_id=1 OR blocks_amount > 1) AND  deleted!='1' AND ad_yandex=1 AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND  test_only!=1  AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ПРОДАЖИ в Москве: '. $count['num'] .'шт. <br><br>';

//-------------------------- ПРОДАЖИ в МО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE  region=1  AND deal_type=2 AND (type_id=1 OR blocks_amount > 1) AND  deleted!='1' AND ad_yandex=1 AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND  test_only!=1  AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ПРОДАЖИ в МО: '. $count['num'] .'шт. <br><br>';



//-------------------------- ПРОДАЖИ в регионах
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE  region NOT IN (1,6)  AND deal_type=2 AND (type_id=1 OR blocks_amount > 1) AND  deleted!='1' AND ad_yandex=1 AND status=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND  test_only!=1  AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ПРОДАЖИ в регионах: '. $count['num'] .'шт. <br><br>';


//---------------------------------всего ПРОДВИЖЕНИЕ
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_yandex=1  AND ad_yandex_promotion=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 || type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО ПРОДВИЖЕНИЕ: '. $count['num'] .'шт. <br><br>';



//-------------------------- всего ПРЕМИУМ
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_yandex=1  AND ad_yandex_premium=1  AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 || type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО ПРЕМИУМОВ: '. $count['num'] .'шт. <br><br>';



//-------------------------- всего ПОДНЯТИЕ
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_yandex=1  AND ad_yandex_raise=1 AND ad_cian_premium=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 || type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО ПОДНЯТИЕ: '. $count['num'] .'шт. <br><br>';


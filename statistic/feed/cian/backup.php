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

$sum = 0;


$data = file_get_contents('https://pennylane.pro/export/xml/cian/feed.xml');

//всего
/*
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE type_id=2 AND  ad_cian=1  AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО : '. $count['num'] .'шт. <br><br>';

*/
echo 'ВСЕГО : '. substr_count($data, '<object>', 0) .'шт. <br><br>';




//всего АРЕНДЫ
/*
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE type_id=2 AND (deal_type=1 OR deal_type=3 OR deal_type=4) AND ad_cian=1  AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО АРЕНДЫ: '. $count['num'] .'шт. <br><br>';
*/
echo 'ВСЕГО : '. (substr_count($data, '<Category>warehouseRent</Category>', 0) + substr_count($data, '<Category>industryRent</Category>', 0) ).'шт. <br><br>';


//всего ПРОДАЖА

$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE type_id=2 AND deal_type=2 AND ad_cian=1  AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)   AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО ПРОДАЖА: '. $count['num'] .'шт. <br><br>';
echo '<br><br>';



//---------------------------------всего ПРЕМИУМОВ
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE type_id=2 AND ad_cian=1  AND ad_cian_premium=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 || type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО ПРЕМИУМОВ: '. $count['num'] . '<br><br>';


//---------------------------------всего ТОП3
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND ad_cian_top3=1 AND  deleted!=1  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 || type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

$price = 7;

echo 'ВСЕГО ТОП3: '. $count['num'] .'<br><br>';
echo '<br><br>';



//---------------------------------всего МОСКВЫ
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 || type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО МОСКВЫ: '. $count['num'] . '<br><br>';



//---------------------------------всего БЛИЖНЕГО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=2 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО БЛИЖНЕГО: '. $count['num'] . '<br><br>';


//---------------------------------всего ДАЛЬНЕГО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=3 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo 'ВСЕГО ДАЛЬНЕГО: '. $count['num'] . '<br><br>';
echo '<br><br>';





//--------------------------ОБЫЧНЫХ для Москвы
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1 AND ad_cian_top3=0 AND ad_cian_premium=0  AND cian_region=1 AND  deleted!=1  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);


$price = 28;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ОБЫЧНЫХ ДЛЯ МОСКВЫ: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';


//---------------------------------ОБЫЧНЫХ для БЛИЖНЕГО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1 AND ad_cian_top3=0 AND ad_cian_premium=0   AND cian_region=2 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);


$price = 12;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ОБЫЧНЫХ ДЛЯ БЛИЖНЕГО: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';


//---------------------------------ОБЫЧНЫХ для ДАЛЬНЕГО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1 AND ad_cian_top3=0 AND ad_cian_premium=0  AND cian_region=3 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

$price = 7;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ОБЫЧНЫХ ДЛЯ ДАЛЬНЕГО: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';
echo '<br><br>';


//--------------------------ТОП3 для Москвы
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=1 AND ad_cian_top3=1 AND  deleted!=1  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

$price = 160;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ТОП3 ДЛЯ МОСКВЫ: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';;



//--------------------------ТОП3 для БЛИЖНЕГО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=2 AND ad_cian_top3=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

$price = 122;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ТОП3 ДЛЯ БЛИЖНЕГО: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';



//--------------------------ТОП3 для ДАЛЬНЕГО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=3 AND ad_cian_top3=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

$price = 66;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ТОП3 ДЛЯ ДАЛЬНЕГО: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';
echo '<br><br>';






//--------------------------ПРЕМИУМ для Москвы
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=1 AND ad_cian_premium=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

$price = 80;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ПРЕМИУМОВ ДЛЯ МОСКВЫ: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';


//--------------------------ПРЕМИУМ для БЛИЖНЕГО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=2 AND ad_cian_premium=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

$price = 61;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ПРЕМИУМОВ ДЛЯ БЛИЖНЕГО: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';



//--------------------------ПРЕМИУМ для ДАЛЬНЕГО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=3 AND ad_cian_premium=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);


$price = 39;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ПРЕМИУМОВ ДЛЯ ДАЛЬНЕГО: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';
echo '<br><br>';



//--------------------------ВЫДЕЛЕНИЕ для Москвы
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=1 AND ad_cian_hl=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'  ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

$price = 80;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ВЫДЕЛЕНИЕ ДЛЯ МОСКВЫ: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';


//--------------------------ВЫДЕЛЕНИЕ для БЛИЖНЕГО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=2 AND ad_cian_hl=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

$price = 61;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ВЫДЕЛЕНИЕ ДЛЯ БЛИЖНЕГО: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';



//--------------------------ВЫДЕЛЕНИЕ для ДАЛЬНЕГО
$sql_text =  "SELECT COUNT(id) as num FROM $table WHERE ad_cian=1  AND cian_region=3 AND ad_cian_hl=1 AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);


$price = 39;
$sum_position = $count['num'] * $price;
$sum += $sum_position;
echo 'ВЫДЕЛЕНИЕ ДЛЯ ДАЛЬНЕГО: '. $count['num'] .'шт  - <b>Цена</b> = '.$price.' руб ;   <b>Сумма</b> = ' . $sum_position .  ' руб  <br><br>';
echo '<br><br>';








echo '<br><br>';

echo '<b>СУММА в сутки </b> = ' .$sum.' руб</b><br><br>';
echo '<b>СУММА в месяц</b> = ' .$sum * 30 .' руб</b><br><br>';


//--------------------------БЕЗ РЕГИОНА
$sql_text =  "SELECT COUNT(object_id) as num  FROM $table WHERE ad_cian=1  AND cian_region=0  AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'  ";

//echo $sql;

$arr_without_region = [];

$sql = $pdo->prepare($sql_text);
$sql->execute();
$count = $sql->fetch(PDO::FETCH_LAZY);

echo '<b> БЕЗ РЕГИОНА : </b> '. $count['num'] .'шт. <br><br>';

//--------------------------БЕЗ РЕГИОНА
$sql_text =  "SELECT DISTINCT(object_id) FROM $table WHERE ad_cian=1  AND cian_region=0  AND  deleted!='1'  AND status=1 AND is_land!=1 AND (price_floor_min > 0 OR  price_sale_min > 0)  AND (blocks_amount>1 OR type_id=1) AND test_only!=1 AND photos!='[\"[]\"]'   ";

//echo $sql;

$sql = $pdo->prepare($sql_text);
$sql->execute();
while($item = $sql->fetch(PDO::FETCH_LAZY)){
    echo '  :  '. $item->object_id .' <br>';
}
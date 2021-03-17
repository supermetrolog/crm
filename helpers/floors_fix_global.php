<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 31.08.2020
 * Time: 16:21
 */

include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';

/*

$arr_floors = [
    '1',
    '2',
    '3',
    '4',
    '5',
    '6',
    '7',
    '8',
    '9',
    '1m',
    '2m',
    '3m',
    '4m',
    '-1',
    '-2',
    '-3',
    '-4',
    '-5',
    '-6',
    '-7',
    '1f',
];

$str = '';

foreach ($arr_floors as $floor) {
    $str .= "'".$floor."',";
}

$str = trim($str,',');

//достаю все блоки из 10248
$sql_blocks = $pdo->prepare("SELECT * FROM c_industry_blocks WHERE floor IN($str) ");
$sql_blocks->execute();
while ($block_info = $sql_blocks->fetch(PDO::FETCH_LAZY) ) {
    $block = new Subitem($block_info->id);
    $block->updateField('floor',json_encode([$block->getField('floor')]));
}

*/

$sql_offers = $pdo->prepare("SELECT id FROM c_industry_offers WHERE id IN(SELECT original_id FROM `c_industry_offers_mix` WHERE `type_id` = '2' AND status=1 AND `floor_min` = '0' AND `floor_max` = '0' AND deleted!=1) ");
$sql_offers->execute();
while ($block_info = $sql_offers->fetch(PDO::FETCH_LAZY) ) {
    $offer = new Offer($block_info->id);
    //var_dump($offer);
    //echo '<br><br><br>';
    $sql = $pdo->prepare("SELECT * FROM c_industry_blocks WHERE offer_id=".$offer->getField('id')."  AND  deleted!=1 AND is_fake IS NULL  ");
    $sql->execute();
    while($block = $sql->fetch()) {
        //echo $block['id'];
    }
    echo $offer->postId().' --- '. json_encode($offer->subItemsActive()) .'<br>';
}
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';


$sql = $pdo->prepare("SELECT *
                      FROM `c_industry_blocks` 
                      WHERE object_id IN(SELECT DISTINCT(object_id) FROM c_industry_offers_mix WHERE  type_id IN (1,2)   AND  deleted!=1 AND hide_from_market !=1  AND status=1 AND is_land!=1  AND test_only!=1 AND photos='".'["[]"]'."')
                      ");
//$sql = $pdo->prepare("SELECT * FROM c_industry WHERE deleted!=1 AND id=10248 ORDER BY id ASC LIMIT $from, $per_page");
$sql->execute();
while ($block = $sql->fetch(PDO::FETCH_LAZY)) {
    $sum_block_id = (int)$block->id;
    $block_obj = new Subitem((int)$block->id);
    $obj = new Building((int)$block->object_id);
    $block_obj->updateField('photo_block',$obj->getField('photo'));
    echo "$sum_block_id <br>";
}



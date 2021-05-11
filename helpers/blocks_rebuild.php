<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';


$sql = $pdo->prepare("SELECT * FROM c_industry_blocks WHERE deleted!=1 ");
//$sql = $pdo->prepare("SELECT * FROM c_industry WHERE deleted!=1 AND id=10248 ORDER BY id ASC LIMIT $from, $per_page");
$sql->execute();
while ($block = $sql->fetch(PDO::FETCH_LAZY)) {
    $sum_block_id = (int)$block->id;
    include($_SERVER['DOCUMENT_ROOT'].'/system/controllers/subitems/merge.php');
}
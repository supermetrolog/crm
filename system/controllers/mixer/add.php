<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');
//require_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

$complex_id = (int)$_POST['complex_id'];
$block_id =  (int)$_POST['part_id'];

$complex = new Complex($complex_id);

$blocks = $complex->getJsonField('mixer_parts');

if(!in_array($block_id,$blocks)){
    $blocks[] = $block_id;
}else{
    unset($blocks[array_search($block_id,$blocks)]);
    sort($blocks);
}


$complex->updateField('mixer_parts',json_encode($blocks));

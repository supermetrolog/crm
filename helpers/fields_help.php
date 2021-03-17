<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';

$sql = $pdo->prepare("SELECT * FROM c_industry_deals WHERE block_id IS NOT NULL");

$sql->execute();

while($item = $sql->fetch(PDO::FETCH_LAZY)){
    $block = new Subitem($item->block_id);
    $block->updateField('deal_id',$item->id);

}

/*
$sql = $pdo->prepare("SELECT * FROM c_industry_parts");

$sql->execute();

while($item = $sql->fetch(PDO::FETCH_LAZY)){
    $part = new Part($item->id);
    $part->updateField('column_grid',json_encode([$item->column_grid]));
    $part->updateField('floor_type',json_encode([$item->floor_type]));
    $part->updateField('floor_type_land',json_encode([$item->floor_type_land]));

    $part->updateField('load_floor_min',$item->load_floor);
    $part->updateField('load_floor_max',$item->load_floor);
    $part->updateField('load_mezzanine_min',$item->load_mezzanine);
    $part->updateField('load_mezzanine_max',$item->load_mezzanine);

}
*/

/*

$sql = $pdo->prepare("SELECT * FROM c_industry_blocks");

$sql->execute();

while($item = $sql->fetch(PDO::FETCH_LAZY)){
    $part = new Subitem($item->id);

    $part->updateField('column_grid',json_encode([$item->column_grid]));
    $part->updateField('floor_type',json_encode([$item->floor_type]));
    $part->updateField('floor_type_land',json_encode([$item->floor_type_land]));

    //$part->updateField('load_floor_min',$item->load_floor);
    //$part->updateField('load_floor_max',$item->load_floor);
    //$part->updateField('load_mezzanine_min',$item->load_mezzanine);
    //$part->updateField('load_mezzanine_max',$item->load_mezzanine);

}


$sql = $pdo->prepare("SELECT * FROM c_industry_blocks");

$sql->execute();

while($item = $sql->fetch(PDO::FETCH_LAZY)){
    $part = new Subitem($item->id);

    $part->updateField('load_floor_min',$item->load_floor);
    $part->updateField('load_floor_max',$item->load_floor);
    $part->updateField('load_mezzanine_min',$item->load_mezzanine);
    $part->updateField('load_mezzanine_max',$item->load_mezzanine);

}



$sql = $pdo->prepare("SELECT * FROM c_industry_complex");

$sql->execute();

while($item = $sql->fetch(PDO::FETCH_LAZY)){
    $part = new Complex($item->id);

    $post = new Post($item->id);
    $post->getTable('c_industry_complex_clone');

    //$part->updateField('guard_type',json_encode([$item->guard]));
    $part->updateField('internet_type',json_encode([$post->getField('internet_type')]));

}

*/
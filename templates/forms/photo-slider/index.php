

<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$photo = $_POST['photo_field'];

//echo $_POST['photo_field'].'<br>';
//echo $_POST['post_id'].'<br>';
//echo $_POST['table_id'].'<br>';

//$object = new Building($_POST['post_id']);

$table = new Table((int)$_POST['table_id']);

$object = new Post($_POST['post_id']);
$object->getTable($table->tableName());

if((int)$_POST['table_id'] == 16 ){
    $offer = new Offer($_POST['post_id']);
    $photos = $offer->getOfferBlocksArrayValuesUnique('photo_block');
}else{
    $photos = $object->getJsonField($photo);
}


//var_dump($photos);

ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);

//var_dump($_POST);
?>
<br>
<div class="slider-complex" >
    <div class="slider flex-box  horizontal-arrows " data-slide-start="<?=(int)$_POST['slide_num']?>">
        <ul class="slides">
            <?foreach($photos as $elem){?>
                <li>
                    <div  class="background-fix" style="background-image: url('<?=$elem?>');  height: 600px">

                    </div>
                </li>
            <?}?>
        </ul>
    </div>
    <div style="height: 10px;">

    </div>
    <div class="slider carousel flex-box horizontal-arrows " style=" height: 200px;" data-slides="4" data-slide-start="<?=$_POST['slide_num']?>">
        <ul class="slides">
            <?foreach($photos as $elem){?>
                <li>
                    <div  class="background-fix" style="background-image: url('<?=$elem?>');  height: 200px">

                    </div>
                </li>
            <?}?>
        </ul>
    </div>
</div>
<!--
<img src="<?='https://pennylane.pro/system/controllers/photos/thumb.php/1600/'.$_POST['post_id'].'/'.$photo?>" class="full-width" />
-->

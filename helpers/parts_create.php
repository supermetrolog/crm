<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';

$logedUser = new Member($_COOKIE['member_id']);

$telegram = new \Bitkit\Social\Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');

$star_time = time();

$sql = $pdo->prepare("DELETE  FROM c_industry_blocks WHERE is_fake=1");
$sql->execute();

$sql = $pdo->prepare("TRUNCATE TABLE c_industry_parts");
$sql->execute();

//достаю все блоки из 10248
$sql = $pdo->prepare("SELECT *  FROM c_industry_blocks WHERE deleted !=1 AND is_fake IS NULL    ");
$sql->execute();



while($item = $sql->fetch(PDO::FETCH_LAZY)) {


    $ids = [];

    $block = new Subitem($item->id);

    if($block->getField('is_land')){
        $part_field = new Part();

        $fields_field = [];
        $values_field = [];
        $area_min = $block->getField('area_floor_min');
        $area_max = $block->getField('area_floor_max');
        $fields_field[] = 'area_field_min';
        $values_field[] = $area_min;
        $fields_field[] = 'area_field_max';
        $values_field[] = $area_max;
        $fields_field[] = 'floor';
        $values_field[] = '1f';
        $fields_field[] = 'power';
        $values_field[] = $block->getField('power');  
        $fields_field[] = 'floor_types_land';
        $values_field[] = json_encode([$block->getField('floor_type_land')]);
        $fields_field[] = 'offer_id';
        $values_field[] = $item->offer_id;
        $fields_field[] = 'object_id';
        $values_field[] = $item->object_id;
        $fields_field[] = 'is_land';
        $values_field[] = $item->is_land;

        $part_field_id = $part_field->createLine($fields_field,$values_field);
        $ids[] = $part_field_id;
    }else{
        //создаем часть на этажах
        $part = new Part();
        $fields = [];
        $values = [];
        foreach ($item as $key=>$value){
            if($key != 'id' && $part->hasField($key)){
                $fields[] = $key;
                $values[] = $value;
            }
        }
        $part_id = $part->createLine($fields,$values);
        $ids[] = $part_id;

        //если есть мезанина площадь то создаем блок мезанина
        if($block->getField('area_mezzanine_min') || $block->getField('area_mezzanine_max')){
            $part_mezz = new Part();
            $fields_mezz = [];
            $values_mezz = [];
            $area_min = $block->getField('area_mezzanine_min');
            $area_max = $block->getField('area_mezzanine_max');

            $load_mezz = $block->getField('load_mezzanine');

            if($area_min == 0){
                $area_min = $area_max;
            }
            if($area_max == 0){
                $area_max = $area_min;
            }
            $fields_mezz[] = 'area_mezzanine_min';
            $values_mezz[] = $area_min;
            $fields_mezz[] = 'area_mezzanine_max';
            $values_mezz[] = $area_max;
            $fields_mezz[] = 'floor';
            $values_mezz[] = '1m';
            $fields_mezz[] = 'floor_types';
            $values_mezz[] = json_encode([2]);
            $fields_mezz[] = 'load_mezzanine';
            $values_mezz[] = $load_mezz;
            $fields_mezz[] = 'offer_id';
            $values_mezz[] = $item->offer_id;
            $fields_mezz[] = 'object_id';
            $values_mezz[] = $item->object_id;

            $part_mezz_id = $part_mezz->createLine($fields_mezz,$values_mezz);
            $ids[] = $part_mezz_id;
        }

        //если есть уличная площадь то создаем блок улицы       
        if($block->getField('area_field_min') || $block->getField('area_field_max')){
            $part_field = new Part();

            $fields_field = [];
            $values_field = [];

            $area_min = $block->getField('area_field_min');
            $area_max = $block->getField('area_field_max');


            if($area_min == 0){
                $area_min = $area_max;
            }
            if($area_max == 0){
                $area_max = $area_min;
            }

            $fields_field[] = 'area_field_min';
            $values_field[] = $area_min;
            $fields_field[] = 'area_field_max';
            $values_field[] = $area_max;
            $fields_field[] = 'floor';
            $values_field[] = '1f';
            $fields_field[] = 'power';
            $values_field[] = $block->getField('power');
            $fields_field[] = 'floor_types_land';
            $values_field[] = json_encode([$block->getField('floor_type_land')]);
            $fields_field[] = 'offer_id';
            $values_field[] = $item->offer_id;
            $fields_field[] = 'object_id';
            $values_field[] = $item->object_id;
            $fields_field[] = 'is_land';
            $values_field[] = $item->is_land;

            $part_field_id = $part_field->createLine($fields_field,$values_field);
            $ids[] = $part_field_id;
        }

    }

    $block->updateField('parts',json_encode($ids));

}



$exec_time = (time() - $star_time)/60;
$message = 'Выгрузка окончена. Времени затрачено: '.$exec_time.' мин';

$telegram->sendMessage($message,$logedUser->getField('telegram_id'));




//header('Location: https://pennylane.pro/helpers/complex_create.php?page='.$next);
echo time() - $star_time;
echo 'сек';
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';

$logedUser = new Member($_COOKIE['member_id']);

$telegram = new \Bitkit\Social\Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');


    $page = 1;
    $sql = $pdo->prepare("TRUNCATE TABLE c_industry_floors  ");
    $sql->execute();


$per_page = 2000;

$from = ($page - 1)*$per_page;


$star_time = time();


//достаю все блоки из 10248
$sql = $pdo->prepare("SELECT i.id,b.floor,b.area_mezzanine_min,b.area_mezzanine_max,b.area_field_min,b.area_field_max,b.is_land  FROM c_industry_blocks b LEFT JOIN c_industry_offers o ON b.offer_id=o.id LEFT JOIN c_industry i ON o.object_id=i.id  WHERE  b.deleted!=1 AND b.is_fake IS NUll  ORDER BY b.id ");
$sql->execute();


//этажи
$floors = [];


while ($item = $sql->fetch(PDO::FETCH_LAZY)) {

    //смотри есть ли у блока мезонин площадь - значит это 1 ур мезонин
    $mezz = $item->area_mezzanine_min + $item->area_mezzanine_max;

    //$field_area = $item->area_field_min + $item->area_filed_max;

    //если еще ни одного этажа пока не нашли
    if($floors[$item->id] == NULL){
        //создаем массив уникальных этажей
        $floors_unique = [];
        //добавляем туд этаж

        if($item->is_land){
            $floors_unique[] = '1f';
        }else{
            $floors_unique[] = $item->floor;
            //проверяем на мезонин если есть - добавляем мезанин
            if($mezz){
                $floors_unique[] = '1m';
            }
        }

        $floors[$item->id] = $floors_unique;
    }else{
        $floors_unique = $floors[$item->id];
        //если такого этажа нету то добавляем
        if($item->is_land){
            if(!in_array('1f',$floors_unique)) {
                $floors_unique[] = '1f';
            }
        }else{
            if(!in_array($item->floor,$floors_unique)) {
                $floors_unique[] = $item->floor;
            }
            //если в блоке есть мез площадь но мы еще не отыскали мезанин
            if($mezz){
                if(!in_array('1m',$floors_unique)) {
                    $floors_unique[] = '1m';
                }
            }
        }

        $floors[$item->id] = $floors_unique;
    }

}

//echo '<br><br>';

//var_dump($floors);




//собираем этажи в виде ОБЪЕКТ - СПИСОК ЭТАЖЕЙ
foreach($floors as $object=>$floors_row){
    //для каждого этажа из  списка
    foreach($floors_row as $floor){
        $floor_obj = new Floor();

        //набираю значения полей для нового этажа
        $fields = [];
        $values = [];

        //
        $fields[] = 'object_id';
        $values[] = $object;

        $sql_floor = $pdo->prepare("SELECT id FROM l_floor_nums WHERE sign='$floor' LIMIT 1");
        $sql_floor->execute();
        $floor_type_info =  $sql_floor->fetch(PDO::FETCH_LAZY);

        $fields[] = 'floor_num_id';
        $values[] = $floor_type_info->id;

        $fields[] = 'floor_num';
        $values[] = $floor;

        $fields[] = 'deleted';
        $values[] = 0;

        //echo 'test------------';

        $floor_new_id = $floor_obj->createLine($fields,$values);
        //echo 'endtest------------';
    }
}

//записываем "натыканные" этажи в здание
foreach($floors as $object=>$floors_row){
    //$signs = implode(',',$floors_row);
    //echo $signs;
    $signs = [];
    foreach($floors_row as $value){
        $signs[] = "'$value'";
    }
    $signs = implode(',',$signs);
    $sql = $pdo->prepare("SELECT id FROM l_floor_nums WHERE sign IN($signs)");
    //echo "SELECT id FROM l_floor_nums WHERE sign IN($signs)";
    $sql->execute();
    $ids = [];
    while($item = $sql->fetch(PDO::FETCH_LAZY)){
        $ids[] = $item->id;
    }
    echo $object;
    var_dump($ids);
    $ids_str = json_encode($ids);
    $building = new Building($object);
    $building->updateField('floors_building',$ids_str);
}



//достаю все блоки из 10248
$sql = $pdo->prepare("SELECT id,floor_num,object_id FROM c_industry_floors   ");
$sql->execute();
$floors = [];
$floors_1 = [];
while ($floor = $sql->fetch(PDO::FETCH_LAZY)) {
    $test = [];
    $test['id'] = $floor->id;
    $test['floor_num'] = $floor->floor_num;
    $test['object_id'] = $floor->object_id;
    $floors[] = $test;
    /*
    var_dump($floor);
    echo '<br>Собрали этаж id '.$floor->id;
    echo '<br>';
    var_dump($floors);
    echo '<br><br>';
    echo '<br><br>';
    $floors_1[] = 1;
    var_dump($floors_1);
    echo '<br><br>';
    echo '<br><br>';
    */
}

//echo '<br><br>';
//echo '<br><br>';
//var_dump($floors);
//var_dump($floors_1);

//echo $floors[0]->queryString;


//------------------------------ОШИБКА ВОТ ТУТ------------------------------------//
//достаю все блоки из 10248
$sql = $pdo->prepare("SELECT id,floor,object_id FROM c_industry_parts WHERE deleted!=1 ORDER BY id ");
$sql->execute();
while($block = $sql->fetch(PDO::FETCH_LAZY)) {
    $block_obj = new Part($block->id);
    //$id = $block->id;
    //echo 'тест айди ---- '.$id;
    foreach($floors as $floor){
        if($floor['floor_num'] == $block->floor && $floor['object_id'] ==  $block->object_id){
            $block_obj->updateField('floor_id',$floor['id']);
            //$floor_id = $floor['id'];
            //echo "UPDATE c_industry_parts SET floor_id=$floor_id WHERE id=$id ";
            //$sql_upd = $pdo->prepare("UPDATE c_industry_parts SET floor_id=$floor_id WHERE id=$id ");

            //$sql_upd->execute();
            //echo '<br>Присвоили этаж этаж  '.$floor->id. '   блоку '.$block->id;
        }
    }
}


//пересчитываем для этажей
$sql = $pdo->prepare("SELECT * FROM c_industry_floors WHERE deleted!=1 ORDER BY id ");
$sql->execute();
while($floor = $sql->fetch(PDO::FETCH_LAZY)) {
    //echo 'СМОТРИМ ЭТАЖ';
    $floor_id = $floor->id;
    $floor_obj = new Floor($floor->id);

    $height_min = 999;
    $height_max = 0;
    $load_floor_min = 999;
    $load_floor_max = 0;
    $floor_types =[];
    $column_grid = [];


    //echo 'ДЛЯ ЭТАЖЕЙ ФИГАЧИМ';

    $sql_blocks = $pdo->prepare("SELECT * FROM c_industry_parts WHERE  floor_id=$floor_id ORDER BY id ");
    $sql_blocks->execute();
    while($block = $sql_blocks->fetch(PDO::FETCH_LAZY)) {
        //для высоты
        if($height_min > $block->ceiling_height_min){
            $height_min = $block->ceiling_height_min;
        }
        if($height_max < $block->ceiling_height_max){
            $height_min = $block->ceiling_height_max;
        }

        //для нагрузки
        if($load_floor_min > $block->load_floor){
            $load_floor_min = $block->load_floor;
        }
        if($load_floor_max < $block->load_floor){
            $load_floor_max = $block->load_floor;
        }

        //для типа пола
        if(!in_array($block->floor_type,$floor_types)){
            $floor_types[] = (int)$block->floor_type;
        }

        //для колонн
        if(!in_array($block->column_grid,$column_grid)){
            $column_grid[] = (int)$block->column_grid;
        }
    }

    if(!$load_floor_max){
        $load_floor_max = $load_floor_min;
    }

    if(!$load_floor_min){
        $load_floor_min = $load_floor_max;
    }



    if(!$height_min){
        $height_min = $height_max;
    }

    if(!$height_max){
        $height_max = $height_min;
    }



    if(!$load_floor_max){
        $load_floor_max = $load_floor_min;
    }

    if(!$load_floor_min){
        $load_floor_min = $load_floor_max;
    }

    $floor_types = json_encode($floor_types);
    $column_grid = json_encode($column_grid);

    $floor_obj->updateLine(['ceiling_height_min','ceiling_height_max','load_floor_min','load_floor_max','floor_types','column_grids'],[$height_min,$height_max,$load_floor_min,$load_floor_max,$floor_types,$column_grid]);

}



$next = $page+1;

$exec_time = (time() - $star_time)/60;
$message = 'Выгрузка этажей  окончена. Времени затрачено: '.$exec_time.' мин';

$telegram->sendMessage($message,$logedUser->getField('telegram_id'));


//header('Location: https://pennylane.pro/helpers/complex_create.php?page='.$next);
echo time() - $star_time;
echo 'сек';
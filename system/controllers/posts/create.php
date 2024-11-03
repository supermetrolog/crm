<?php

/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 07.05.2018
 * Time: 9:50
 */

if ($_COOKIE['member_id'] == 941) {
    //ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);
    //var_dump($_POST);
}



require_once($_SERVER['DOCUMENT_ROOT'] . '/global_pass.php');

if ($_POST['id']) {
    $id = (int)$_POST['id'];
    $action_id = 3;
} else {
    $id = 0;
    $action_id = 1;
}

$table_id = (int)$_POST['table_id'];
$table = (new Table($table_id))->tableName();

//echo $table;
$telegram = new \Bitkit\Social\Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');


//var_dump($_POST);

//echo $table;


$logedUser = new Member($_COOKIE['member_id']);
if ($logedUser->is_valid()) {

    // echo '---';
    $post = new Post($id);

    $post->getTable($table);

    //$telegram->sendMessage($_POST['agent_id'], $logedUser->getField('telegram_id'));


    //получаем значения ДО обновления
    //$post_before = $post->getLine();

    $post_id = $post->createUpdate();

    //НУЖНО ДЛЯ РАБОТЫ НО ЭТО ГЛУБОКИЙ КОСЯК Unit.php возможно
    $post = new Post($post_id);
    $post->getTable($table);

    //для запросов создаем автоматом сделку
    $requests = new Request(0);
    if ($table == $requests->setTable() && !$id) {
        //создаем сделку
        $deal = new Deal(0);
        $deal_id = $deal->createUpdate();
        //проставляем запросу ID сделки
        $request = new Request($post_id);
        $request->updateField('deal_id', $deal_id);
    }

    //ЕСЛИ ЭТО УЧАСТОК ЗЕМЛИ ТО АВТОМАТОМ СОЗДАЕМ ЭТАЖ ИЛИ ПЕРЕСОХРАНЯЕМ
    if ($table_id == 5 && $post->getField('is_land')) {



        $floor_fields = [];
        $floor_values = [];

        //смотрим этаж если есть то находим если нет то создаем
        $floor = new Floor();

        foreach ($_POST as $key => $value) {
            if ($key != 'id' && $floor->hasField($key)) {
                $floor_fields[] = $key;
                $floor_values[] = $value;
            }
        }

        //тут набираем массив
        if ($floor->getFloorFieldByObjectId($post_id) == 0) {
            $floor_id = $floor->createLine($floor_fields, $floor_values);
            $floor = new Floor($floor_id);

            //если создаем то добавляем номер объекта
            $floor_fields[] = 'object_id';
            $floor_values[] = $post_id;

            $floor_fields[] = 'floor_num';
            $floor_values[] = '1f';

            $floor_fields[] = 'floor_num_id';
            $floor_values[] = 16;


            $telegram->sendMessage('создали этаж улицы', $logedUser->getField('telegram_id'));
        }

        $floor->updateLine($floor_fields, $floor_values);
    }

    //Отправка почты
    /*
    if($table_id == '31'){

        $user_id = $logedUser->member_id();
        $to_name = 'some email';
        $to = json_decode($post->getField('emails'));
        $topic = $post->getField('email_topic');

        $title = urlencode($post->getField('title'));
        $description = urlencode($post->getField('description'));
        $offers_str = urlencode($post->getField('email_offers'));

        if( $curl = curl_init() ) {
            curl_setopt($curl, CURLOPT_URL, PROJECT_URL."/templates/emails/simple.php?title=$title&description=$description&offers=$offers_str&member_id=$user_id");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $out = curl_exec($curl);
            $msg =  $out;
            curl_close($curl);
        }
        $email = new Bitkit\Core\Messaging\Email(SMTP_HOST,SMTP_PORT,SMTP_USER,SMTP_PASSWORD);
        foreach($to as $address){
            $email->smtpmail($to_name, $address, $topic, $msg);
        }

    }
    */

    //ДЛЯ ПРОСТЛЕНИЯ КОНТАКТА КОМПАНИИИ
    if ($table_id == '15') {
        $company = new Company((int)$_POST['company_id']);
        if (!$company->hasContact()) {
            $company->setContact($post_id);
        }
    }

    //ДЛЯ СОЗДАНИЯ СДЕЛКИ ПРОСТАВЛЯЕМ ЕЕ id ТП к которому она создана
    if ($table_id == '23') {
        $block = new Subitem((int)$post->getField('block_id'));
        $block->updateField('deal_id', $post->postId());
    }


    //получаем значения ПОСЛЕ обновления
    $post_after = $post->getLine();


    //writing action Log
    /*
    if($post_id){
        $actionLog = new UserAction(0);
        $actionLog->logAction($action_id,$table,$post_id,0,0, $post_before, $post_after);
    }
    */


    if (in_array($table_id, [11])) {
        $curr_block = new Subitem($post->postId());
        $stacks = $curr_block->getBlockStacks();
        foreach ($stacks as $elem) {
            $sum_block_id = $elem;
            include(PROJECT_ROOT . '/system/controllers/subitems/merge.php');
        }
    }


    //пересобираем торговые предложения из частей
    if ($table_id == 35) {
        $like = '%"' . $post_id . '"%';
        $sql = $pdo->prepare("SELECT id  FROM c_industry_blocks WHERE parts LIKE '$like'");
        $sql->execute();
        while ($item = $sql->fetch(PDO::FETCH_LAZY)) {
            $sum_block_id = $item['id'];
            include($_SERVER['DOCUMENT_ROOT'] . '/system/controllers/subitems/merge.php');
        }
    }



    //обновление КЭШ ТАБЛИЦЫ ФИДОВ
    if (in_array($table_id, [5, 16, 11, 35])) {
        if (1) {
            //if($_COOKIE['member_id'] == 141){
            if ($table_id == 35) {
                if ($_POST['id']) {
                    include_once(PROJECT_ROOT . '/table/feed_create.php');
                }
            } else {
                include_once(PROJECT_ROOT . '/table/feed_create.php');
            }
        }
    }


    //СМОТРИМ AJAX или нет
    if ($_POST['ajax']) {
        $response = ['post_id' => $post_id, 'table' => $table];
        echo json_encode($response);
    } else {
        if ($logedUser->isAdmin() && $_POST['admin_panel']) {
            header("Location: " . PROJECT_URL . '/' . "admin/index.php?action=show&type=" . $table);
        } else {
            if ($table_id == '16') {
                $offer_id = $post_id;
                $offer = new Offer($post_id);
                $object_id = $offer->getField('object_id');
                $obj = new Building($object_id);
                $complex_id = $obj->getField('complex_id');
                echo $_POST['complex_id'];
                if ($_POST['complex_id']) {
                    $loc = "https://pennylane.pro/complex/$complex_id?offer_id=['.$offer_id.]";
                } else {
                    //$loc = "https://pennylane.pro/object/$object_id?offer_id=$offer_id#offers";
                    $loc = "https://pennylane.pro/complex/$complex_id?offer_id=[$offer_id]";
                }


                if ($logedUser->member_id() == 941) {
                } else {
                    header("Location: " . $loc);
                }
            } elseif ($table_id == '33') {
                header("Location: " . "https://pennylane.pro/complex/" . $post_id);
            } else {
                if ($logedUser->member_id() == 941) {
                } else {
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                }
            }
        }
    }
} else {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    echo "F*ck you, hacker=)";
}

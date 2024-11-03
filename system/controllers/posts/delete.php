<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

if ($_COOKIE['member_id'] == 141) {
    //ini_set('error_reporting', E_ALL);ini_set('display_errors', 1); ini_set('display_startup_errors', 1);
}

$id = (int)$_POST['id'];
$table_id = (int)$_POST['table_id'];
$table = (new Table($table_id))->tableName();

$telegram = new \Bitkit\Social\Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');

//$telegram->sendMessage('вошли в скрипт удаления','223054377');


//echo $id.'<br>';


$logedUser = new Member($_COOKIE['member_id']);
if($logedUser->is_valid()){
    $post = new Post($id);
    $post->getTable($table);
    if($post_id = $post->postDelete()){
        //$action_id = 2;
        //(new UserAction(0))->logAction($action_id,$table,$post_id,0,0,'','');
    }

    //если удаляем кусок
    if($table_id == 11){
        $block = new Subitem($post_id);
        $block->updateField('last_update',time());
    }

    //если удаляем кусок
    if($table_id == 35){

        /* Это удаление все ТП в состав которых входит кусок - рабоатет норм но хотим пересобирать
        $like = '%"'.$id.'"%';
        $sql = $pdo->prepare("UPDATE c_industry_blocks SET deleted=1 WHERE parts LIKE '$like'");
        //echo "DELETE  FROM c_industry_blocks WHERE parts LIKE '$like'";
        $sql->execute();
        */

        $telegram->sendMessage('работаем с элементами куска','223054377');


        $like = '%"'.$id.'"%';
        $some_text  = "SELECT id  FROM c_industry_blocks WHERE parts LIKE '$like' AND deleted !=1";
        $telegram->sendMessage($some_text,'223054377');
        $sql = $pdo->prepare("SELECT id  FROM c_industry_blocks WHERE parts LIKE '$like' AND deleted !=1");
        $telegram->sendMessage($some_text,'223054377');
        $sql->execute();
        while($item = $sql->fetch(PDO::FETCH_LAZY)){
            $sum_block_id = $item->id;

            $subitem = new Subitem((int)$item->id);

            //корректируем записи про сами блоки
            $parts_in_block = $subitem->getJsonField('parts');
            $parts_new = [];
            foreach ($parts_in_block as $part_id) {
                if ($part_id != $id ) {
                    $parts_new[] = $part_id;
                }
            }
            $subitem->updateField('parts',json_encode($parts_new));

            //корректируем записи про то что включено/исключено
            $parts_info_block = $subitem->getJsonField('excluded_areas');
            $parts_info_new = [];
            foreach ($parts_info_block as $part_id => $info) {
                if ($part_id != $id ) {
                    $parts_info_new[$part_id] = $info;
                }
            }
            $subitem->updateField('excluded_areas',json_encode($parts_info_new));



            $telegram->sendMessage($item->id,'223054377');
            include($_SERVER['DOCUMENT_ROOT'].'/system/controllers/subitems/merge.php');
            $telegram->sendMessage('пеерсобрал блок '.$sum_block_id,'223054377');
        }

        //удаляем все MIX торговые предложения у которых object_id равен объекту где кусок
        $sql = $pdo->prepare("DELETE FROM c_industry_offers_mix WHERE object_id=".$post->getField('object_id'));
        $sql->execute();


    }

    $telegram->sendMessage('удалили','223054377');


    //если удаляем сделку
    if($table_id == 23){
        $block = new Subitem($post->getField('block_id'));
        $block->updateField('deal_id',0);

    }

    //если удаляем предложение
    if($table_id == 16){

        //$telegram->sendMessage('удалили блоки','223054377');

        //$telegram->sendMessage('id предложения '.$id,'223054377');

        $sql = $pdo->prepare("UPDATE c_industry_blocks SET deleted=1 WHERE offer_id=$id");
        $sql->execute();

        $sql = $pdo->prepare("DELETE FROM c_industry_offers_mix WHERE object_id=".$post->getField('object_id'));
        $sql->execute();
    }


    //обновление КЭШ ТАБЛИЦЫ ФИДОВ
    if(in_array($table_id,[5,16,11])){

        $mix_delete = 1;
        include_once (PROJECT_ROOT.'/table/feed_create.php');

        $logedUser->reviewFavourites();
    }



    header("Location: ".$_SERVER['HTTP_REFERER']);
}else{
    echo "F*ck you, hacker=)";
}

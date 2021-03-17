<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 04.05.2018
 * Time: 13:15
 */
?>
<?if($user_id == $logedUser->member_id()){?>
    <? require_once('record-form.php') ?>
<?}elseif($user_id == $logedUser->member_id()){?>
    <div class="ghost">
        Вы исчерпали месячный лимит записей
    </div>
<?}else{?>

<?}?>
<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 04.05.2018
 * Time: 13:15
 */
?>



<div class='records-list'>
    <?
    $records = new Record(0);
    foreach ($records->getAllUnitsReverse() as $record){
        $listRecord = new Record($record['id']);
        $author = new Member($listRecord->author());
        if($listRecord->author() == $user_id){
            if($listRecord->canSee()){?>
                <? include($_SERVER["DOCUMENT_ROOT"] . '/templates/records/list/index.php');?>
            <?}?>
        <?}?>
    <?}?>
</div>


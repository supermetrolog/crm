<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 27.06.2019
 * Time: 16:35
 */
?>
<?php
$user = new Member($_COOKIE['member_id']);

//include_once ($_SERVER['DOCUMENT_ROOT'].'/display_errors.php');
$statuses = ['1'=>'Актив','2'=>'Пассив'];
if($_POST['table']){
    $table_id = $_POST['table'];
}else{
    $table_id = $post->setTableId();
}
?>
<?if($src['status_reason'] == 10 && !$user->isAdmin()){?>
    <div class="attention isBold">
        ЗАБЛОКИРОВАНО МОДЕРАТОРОМ
    </div>
<?}else{?>
    <div class="complex-status">
        <div class="flex-box flex-wrap ">
            <?foreach($statuses as $key=>$value){?>
                <?
                if(!$src[$field->title()] && $key == 1){
                    $stat_default = 1;
                }else{
                    $stat_default = 0;
                }


                ?>
                <div class="toggle-checkbox field-status" style="margin: 3px;">
                    <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-<?=$key?>" value="<?=$key?>" name="status" <?=($key == $src[$field->title()] || $stat_default) ? 'checked' : '' ;?> type="radio"/>
                    <label for="<?=trim($field->title())?>-<?=$key?>">
                        <?=$value?>
                    </label>
                </div>
            <?}?>
        </div>
        <div class="status-extends <?=($src[$field->title()] == 2) ? '' : 'hidden'?>">
            <div class="box-vertical">
                <select <?=($src[$field->title()] == 2) ? 'required' : 'disabled'?> id="field-<?=$field->title()?>" class="<?= (trim($src['status_reason'])) ? 'field-checked' :'' ?>" <?=($field->getField('field_required') ? 'required' : '')?> name='status_reason' <?=($field->getField('field_is_disabled')) ? 'disabled' : '' ?>>
                    <?

                    if(trim($src['status_reason']) && !in_array($src['status_reason'],[16,17,18,19]) ){
                        $table_post = new Post($src['status_reason']);
                        $table_post->getTable($field->getField('linked_table'));
                        echo "<option value='".$table_post->postId()."'>".$table_post->title()."</option>";
                    }else{
                        echo "<option value=''>Выберите</option>";
                    }
                    if(!$field->getField('field_list_empty')){
                        $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table')." WHERE active !=1 ");
                        $sql->execute();
                        while($sql_src = $sql->fetch(PDO::FETCH_LAZY)){
                            //if($src[$field->title()] != $sql_src->id && $sql_src->title && $table_id == $sql_src->table_id){
                            if($src[$field->title()] != $sql_src->id && $sql_src->title && in_array($table_id,json_decode($sql_src->table_id)) && in_array((int)$src['is_land'],json_decode($sql_src->is_land)) && in_array($user->isAdmin(),json_decode($sql_src->permission_groups)) ){
                                echo "<option value='".$sql_src->id."'>".$sql_src->title."</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <?if($table_id == 11){?>
        <div class="status-extends-active <?=($src[$field->title()] == 1 || $src[$field->title()] == '') ? '' : 'hidden'?>">
            <div class="box-vertical">
                <select  <?=($src[$field->title()] == 1) ? 'required' : ' disabled'?>  id="field-<?=$field->title()?>" class="<?= (trim($src['status_reason'])) ? 'field-checked' :'' ?>" <?=($field->getField('field_required') ? 'required' : '')?> name='status_reason' <?=($field->getField('field_is_disabled')) ? 'disabled' : '' ?>>
                    <?

                    if(trim($src['status_reason'] && in_array($src['status_reason'],[16,17,18,19]))){
                        $table_post = new Post($src['status_reason']);
                        $table_post->getTable($field->getField('linked_table'));
                        echo "<option value='".$table_post->postId()."'>".$table_post->title()."</option>";
                    }else{
                        echo "<option value=''>Выберите</option>";
                    }
                    if(!$field->getField('field_list_empty')){
                        $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table')." WHERE active=1  ");
                        $sql->execute();
                        while($sql_src = $sql->fetch(PDO::FETCH_LAZY)){
                            //if($src[$field->title()] != $sql_src->id && $sql_src->title && $table_id == $sql_src->table_id){
                            if($src[$field->title()] != $sql_src->id && $sql_src->title && in_array($table_id,json_decode($sql_src->table_id)) && in_array((int)$src['is_land'],json_decode($sql_src->is_land)) && in_array($user->isAdmin(),json_decode($sql_src->permission_groups)) ){
                                echo "<option value='".$sql_src->id."'>".$sql_src->title."</option>";
                            }
                        }
                    }
                    ?>
                </select>
            </div>
        </div>
        <?}?>
        <div class="status-time <?if(!in_array($src['status_reason'],[16,17,18,19])){?> hidden  <?}?>">
            <label for="party">Освобождается:</label>
            <input type="text" id="datepicker-from" value="<?=date('d.m.Y',$src['available_from'])?>" name="available_from" min="" max="">
        </div>
        <div class="box-small">

        </div>
        <div class="status-text <?=($src[$field->title()] == 1 || $src[$field->title()] == 0) ? 'hidden' : ''?> ">
            <textarea style="height: 100px !important; " name='status_description' <?=($field->getField('field_required') ? 'required' : '')?>  placeholder=' '><?=($src['status_description'])? $src['status_description'] : ''; ?></textarea>
        </div>

    </div>
<?}?>




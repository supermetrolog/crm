<?
if($_POST[$field->title()]){
    $value_item = $_POST[$field->title()];
}else{
    $value_item = $src[$field->title()];
}

//ДЛЯ АКТИВНЫХ АГЕНТОВ
if($field->title() == 'agent_id'){
    $active = 'WHERE activity=1';
}else{
    $active = '';
}

if($_COOKIE['member_id'] == 141){
    //include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
}

?>
<div class="flex-box">
    <div class="datalist-company-block" style="width: 60%;">
        <div class="datalist-field"  style="position: relative; ">
            <?if($src[$field->title()]){?>
                <?$val = new Post($src[$field->title()])?>
                <?$val->getTable($field->getField('linked_table'))?>
                <?
                if($val->getField('title')){
                    $val_res = $val->getField('title');
                }elseif($val->getField('title_eng')){
                    $val_res = $val->getField('title');
                }else{
                    $val_res = $val->getField('title_old');
                }
                ?>
                <?$val_res = str_replace('"','',$val_res)?>
            <?}?>

            <span></span>
            <input data-table="<?=$field->getField('linked_table')?>" class="datalist-input" data-async="1"  type="text" value="<?=$val_res?>" />
            <input type="hidden" value="<?=$src[$field->title()]?>" name="<?=$field->title()?>"/>
            <div class="field-list-variants box-small" style="position: absolute; display: none; background: white; z-index: 999; height: 150px; width: 100%;  overflow-y: scroll; border: 1px solid grey" >

            </div>
        </div>
    </div>

    <style>
        .field-list-variants{

        }

        .field-list-variants > div:hover{
            background: blue;
            color: white;
        }
    </style>
    <div style="width: 40%;">
        <select style="width: 100%;" id="field-<?=$field->title()?>_type" class="<?= $src[$field->title().'_type'] ? 'field-checked' :'' ?>" <?=($field->getField('field_required') ? 'required' : '')?> name='<?=$field->title()?>_type' <?=($field->getField('field_is_disabled')) ? 'disabled' : '' ?>>
            <?

            if($type = $src[$field->title().'_type']){
                $table_post = new Post($type);
                $table_post->getTable('l_towns_types');
                echo "<option value='".$table_post->postId()."'>".$table_post->title()."</option>";
            }else{
                echo "<option value=''>Выберите</option>";
            }
            if(!$field->getField('field_list_empty')){
                $sql = $pdo->prepare("SELECT * FROM  l_towns_types ORDER BY title ASC");
                $sql->execute();
                while($sql_src =$sql->fetch(PDO::FETCH_LAZY)){
                    if($src[$field->title().'_type'] != $sql_src->id && $sql_src->title){
                        echo "<option value='".$sql_src->id."'>".$sql_src->title."</option>";
                    }
                }
            }
            ?>
        </select>            
    </div>
</div>


<?

$value_item = '';
$val_res = '';

?>
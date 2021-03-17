<?
/*
if($src[$field->title()] != ''){
    $table_post = new Post($src[$field->title()]);
    $table_post->getTable($field->getField('linked_table'));
    $field_value = $table_post->title();
}
?>
<input  name="<?=$field->title()?>" list="<?=$field->title()?>" type="text" placeholder="<?=$field_value?>" <?=($field->getField('field_required') ? 'required' : '')?> value='<?= $_POST['company_id'] ?? $src[$field->title()]?>' />
<datalist id="<?=$field->title()?>">
    <?
    $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table'));
    $sql->execute();             
    while($sql_src = $sql->fetch(PDO::FETCH_LAZY)){?>
        <option label="<?=$sql_src->title?> <?=$sql_src->title_eng?>" value="<?=$sql_src->id?>" />
    <? } ?>
</datalist>
*/
?>

<?// include_once($_SERVER['DOCUMENT_ROOT'].'/display_errors.php')?>

<?
if(!$field->getField('is_multifield')){
    $value_item = $src[$field->title()];
    $name = $field->title();
}else{
    $name = $field->title().'[]';
}

?>

<div class="datalist-company-block">
    <div class="datalist-field"  style="position: relative;">
        <?if($value_item){?>
            <?$val = new Post($value_item)?>
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
        <input type="hidden" value="<?=$value_item?>" name="<?=$name?>"/>
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

<?
$value_item = '';
$val_res = '';

?>


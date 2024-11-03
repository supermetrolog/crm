<?// include_once($_SERVER['DOCUMENT_ROOT'].'/display_errors.php')?>

<div class="datalist-field"  style="position: relative;">
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
    <div class="field-list-variants box-small" style="position: absolute; display: none; background: white; z-index: 999; height: 150px; width: 100%;  overflow-y: scroll; border: 1px solid grey">

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

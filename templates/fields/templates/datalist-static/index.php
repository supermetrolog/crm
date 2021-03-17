<?// include_once($_SERVER['DOCUMENT_ROOT'].'/display_errors.php')?>

<div class="datalist-field"  style="position: relative;">
    <?$val = new Post($src[$field->title()])?>
    <?$val->getTable($field->getField('linked_table'))?>
    <span style="display: none;"></span>
    <input data-table="<?=$field->getField('linked_table')?>" class="datalist-input"   type="text" value="<?=str_replace('"','',$val->title())?>" />
    <input type="hidden" name="<?=$field->title()?>"/>
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
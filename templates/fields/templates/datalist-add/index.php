<?// include_once($_SERVER['DOCUMENT_ROOT'].'/display_errors.php')?>

<div class="datalist-add">
    <div class="datalist-field" data-name="<?=$field->title()?>" style="position: relative;">


        <span></span>
        <input  data-table="<?=$field->getField('linked_table')?>" class="datalist-input" data-async="1"  type="text" value="" />
        <input class="datalist-input-hidden" type="hidden" value="" />
        <div class="field-list-variants datalist-multicheck box-small" style="position: absolute; display: none; background: white; z-index: 999; height: 150px; width: 100%;  overflow-y: scroll; border: 1px solid grey">

        </div>
    </div>
    <div class="flex-box datalist-selected">
        <?php
        $values = json_decode($src[$field->title()]);
        foreach($values as $value){
            $datalist_item = new Post($value);
            $datalist_item->getTable($field->getField('linked_table'));?>
            <div class="datalist-selected-item flex-box" >
                <div>
                    <?=$datalist_item->title()?>
                </div>
                <div>
                    <input type="hidden" value="<?=$datalist_item->postId()?>" name="<?=$field->title()?>[]"  />
                </div>
                <div class="box-wide pointer">
                    <i class="far fa-times"></i>
                </div>
            </div>
            <?
        }
        ?>
    </div>
    <?$field_table = new Table()?>
    <?$field_table->getTableByName($field->getField('linked_table'))?>
    <div class="datalist-add-btn pointer icon-round" style="" data-table="<?=$field_table->tableId()?>" title="Добавить">
        +
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

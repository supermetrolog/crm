<?if(!$arr_value){
    $arr_value = ['',''];
}?>
<div class="flex-box">
    <div class="flex-box" >
        <div style="border: 1px solid #E0E0DD; background: #ffffff; ">
            <input step="0.1" <?if($field->getField('field_required')){?> required <?}?> <?if($field->getField('field_is_disabled')){?> disabled <?}?> style="width: 40px !important" class="filter-input" min="0" name="<?=$field->title()?>[]" value="<?= $arr_value[0] ? $arr_value[0]  :  ''?>"  type="number" placeholder=" " />
        </div>
        <div class="ghost">
            <?=$field->getField('dimension_first')?>
        </div>
    </div>
    <div>
        -
    </div>
    <div class="flex-box" >
        <div style="border: 1px solid #E0E0DD;  background: #ffffff;">
            <input step="0.1" <?if($field->getField('field_required')){?> required <?}?> <?if($field->getField('field_is_disabled')){?> disabled <?}?>  style="width: 40px !important" class="filter-input" min="0" name="<?=$field->title()?>[]" value="<?=($arr_value[1]) ? $arr_value[1] : ''?>"  type="number" placeholder=" " />
        </div>
        <div class="ghost">
            <?=$field->getField('dimension_last')?>
        </div>
    </div>
</div>

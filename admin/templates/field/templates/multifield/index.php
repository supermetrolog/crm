<div class="flex-box">
    <div class="multifield-container">

        <?if(trim($placeholder = $field->getField('field_placeholder'))){?>
            <?$placeholder = 'title="'.$placeholder.'"';?>
        <?}else{?>
            <?$placeholder ='';?>
        <?}?>

        <?if(trim($pattern = $field->getField('field_pattern'))){?>
            <?$pattern = 'pattern="'.$placeholder.'"';?>
        <?}else{?>
            <?$pattern ='';?>
        <?}?>
        <?if( $fields = json_decode($src[$field->title()])[0] != NULL){?>
            <?foreach (json_decode($src[$field->title()]) as $item){?>
                <?if($item){?>
                    <input placeholder=' ' <?=$placeholder?>  type="<?=$field->getField('field_input_type')?>" name="<?=$field->title()?>[]" value='<?=$item?>' /><br>
                <?}?>
            <?}?>
        <?}else{?>
            <input placeholder=' ' <?=$placeholder?>  type="<?=$field->getField('field_input_type')?>" name="<?=$field->title()?>[]"  /><br>
        <?}?>
    </div>
    <div title="Добавить поле" class="icon-round to-end more-fields pointer">+</div>
</div>
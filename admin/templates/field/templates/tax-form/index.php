<div class="flex-box flex-wrap">
    <?foreach($field->getFieldVariants() as $field_item){
        ?>
        <?if($_POST['deal_type']){
            $deal_type = $_POST['deal_type'];
        }else{
            $deal_type = $post->getField('deal_type');
        }?>
        <?if($field->title() == 'tax_form' &&  in_array($deal_type,[2,3]) ){?>
            <?if($field_item['id'] != 1){?>
                <div class="toggle-checkbox" style="margin: 3px;">
                    <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>" <?=($field_item['id'] == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                    <label for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                        <?=$field_item['title_short']?>
                    </label>
                </div>
            <?}?>
        <?}else{?>
            <div class="toggle-checkbox" style="margin: 3px;">
                <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>" <?=($field_item['id'] == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                <label for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                    <?=$field_item['title_short']?>
                </label>
            </div>
        <?}?>
    <?}?>
</div>
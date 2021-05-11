<div class="flex-box flex-wrap">
    <?foreach($field->getFieldVariants() as $field_item){?>
            <div class="toggle-checkbox" style="margin: 3px;">
                <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>" <?=($field_item['id'] == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
                <label for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                    <?if($field_item['title_short']){?>
                        <?=$field_item['title_short']?>
                    <?}elseif($field_item['icon']){?>
                        <?=$field_item['icon']?>
                    <?}else{?>
                        <?=$field_item['title']?>
                    <?}?>
                </label>
            </div>
    <?}?>
</div>
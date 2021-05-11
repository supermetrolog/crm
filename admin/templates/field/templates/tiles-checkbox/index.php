<div class="flex-box flex-wrap">
    <?foreach($field->getFieldVariants() as $field_item){
        ?>
        <div class="toggle-checkbox" style="margin: 3px;">
            <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],json_decode($src[$field->title()]))) ? 'checked' : '' ;?> type="checkbox"/>
            <label for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                <?=$field_item['title_short']?>
            </label>
        </div>
    <?}?>
</div>
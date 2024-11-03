<div class="flex-box field-module">
    <div class=" <?if($src[$field->title()] != 1){?> hidden <?}?> field-step-2">
        <div>
            <input  <?if($field->getField('field_required')){?> required <?}?>   type="number" name="<?=trim($field->title())?>_value" value="<?=$src[$field->title().'_value']?>" />
        </div>
    </div>
    <div class="flex-box flex-wrap field-step-1 box-wide">
        <div class="toggle-checkbox no-value" style="margin: 3px;">
            <input   <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-2" value="2" name="<?=trim($field->title())?>" <?=(2 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
            <label  for="<?=trim($field->title())?>-2">
                Не знаю
            </label>
        </div>
        <div class="toggle-checkbox yes-value" style="margin: 3px;">
            <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-1" value="1" name="<?=trim($field->title())?>" <?=(1 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
            <label for="<?=trim($field->title())?>-1">
                Включено в цену
            </label>
        </div>
    </div>
</div>
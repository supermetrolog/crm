<div class="flex-box field-module">
    <div class="flex-box flex-wrap field-step-1">
        <div class="toggle-checkbox yes-value" style="margin: 3px;">
            <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-1" value="1" name="<?=trim($field->title())?>" <?=(1 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
            <label for="<?=trim($field->title())?>-1">
                да
            </label>
        </div>
        <div class="toggle-checkbox no-value" style="margin: 3px;">
            <input   <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-2" value="2" name="<?=trim($field->title())?>" <?=(2 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
            <label  for="<?=trim($field->title())?>-2">
                нет
            </label>
        </div>
    </div>
    <div class="box-wide <?if($src[$field->title()] != 1){?> hidden <?}?> field-step-2">
        <div>
            <input step="0.1"   type="number" name="<?=trim($field->title())?>_value" value="<?=$src[$field->title().'_value']?>" />
        </div>
    </div>
</div>
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
        <div class="flex-box ">
            <div class="flex-box" style="border: 1px solid #E0E0DD; background: #ffffff;">
                <div>
                    <input step="0.1" min="0" <?//=$field_max_value?> class="filter-input input-range" name="<?=$field->title()?>_value_min" value="<?=$src[$field->title().'_value_min'] ? $src[$field->title().'_value_min'] : ''?>"  type="number" placeholder=" " />
                </div>
            </div>
            <div>
                -
            </div>
            <div class="flex-box" style="border: 1px solid #E0E0DD;  background: #ffffff;">
                <div>
                    <input step="0.1" min="0" <?//=$field_max_value?> class="filter-input input-range" name="<?=$field->title()?>_value_max" value="<?=$src[$field->title().'_value_max'] ? $src[$field->title().'_value_max'] : ''?>"  type="number" placeholder=" " />
                </div>
            </div>
        </div>
    </div>
</div>
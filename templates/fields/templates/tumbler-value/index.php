<div class="flex-box flex-vertical-center">
    <div>
        <div class="toggle-item flex-box flex-vertical-center">
            <div class="toggle-bg">
                <input type="radio" name="<?=$field->title()?>" value="0">
                <input type="radio" name="<?=$field->title()?>" <?=($src[$field->title()] == 1 ) ? 'checked' : '';?> value="1">
                <div class="filler"></div>
                <div class="switch"></div>
            </div>
        </div>
    </div>
    <div >
        <input style="max-width: 50px;" type='number' name='<?=$field->title()?>_value' <?=$field->getField('require_type')?>  placeholder='<?=$field->description()?>' value='<?=($src[$field->title().'_value'])? $src[$field->title().'_value'] : ''; ?>'/>
    </div>
</div>
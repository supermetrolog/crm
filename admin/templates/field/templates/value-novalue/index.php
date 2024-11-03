
<div class="value-novalue">
    <div class="value-to-switch">
        <input type="hidden" name="<?=$field->title()?>" value="" />
        <input class="input-main"  id="field-<?=$field->title()?>"  type="<?=$field->getField('field_input_type')?>"   name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?> <?if($src[$field->title().'_novalue']){?>disabled <?}?>  placeholder=' ' value='<?=$src[$field->title()] ?? ''; ?>' />
    </div>
    <div class="box-small-vertical flex-box">
        <div class="toggle-item flex-box flex-vertical-center test">
            <div class="toggle-bg">
                <input type="radio" name="<?=$field->title()?>_novalue" value="0">
                <input type="radio" name="<?=$field->title()?>_novalue" <?=($src[$field->title().'_novalue'] == 1 ) ? 'checked' : '';?> value="1">
                <div class="filler"></div>
                <div class="switch"></div>
            </div>
        </div>
        <div>
            <?=$field->getField('field_before') ?? ''?>
        </div>
    </div>
</div>







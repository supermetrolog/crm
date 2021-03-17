<div class="box">
    <div class="box">
        <?
        $vars_arr = explode(',',$field->getField('input_vars'));
        foreach ($vars_arr as $radio_var){?>
            <label class="radio-container">
                <input <?=($src[$field->title()] == $radio_var)? 'checked' : '';?> type="radio" value="<?=$radio_var?>" name="<?=$field->title()?>" /><?=$radio_var?>
                <span class="checkmark"></span>
            </label>
        <?}?>
    </div>
</div>
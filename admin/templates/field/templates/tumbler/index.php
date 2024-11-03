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
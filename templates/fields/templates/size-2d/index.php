<div class="flex-box">
    <?
    if($src[$field->title().'_length']){
        $length = $src[$field->title().'_length'];
    }else{
        $length = '';
    }

    if($src[$field->title().'_width']){
        $width = $src[$field->title().'_width'];
    }else{
        $width = '';
    }

    ?>
    <div class="flex-box" style="border: 1px solid #E0E0DD; background: #ffffff;">
        <div>
            <input style="width: 45px !important;" class="filter-input" name="<?=$field->title()?>_length" value="<?=$length?>"  type="number" placeholder=" " />
        </div>
    </div>
    <div>
        x
    </div>
    <div class="flex-box" style="border: 1px solid #E0E0DD;  background: #ffffff;">
        <div>
            <input style="width: 45px !important;" class="filter-input" name="<?=$field->title()?>_width" value="<?=$width?>"  type="number" placeholder=" " />
        </div>
    </div>
    <div>
        <?// ?>
    </div>
</div>
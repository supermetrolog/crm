<div class="flex-box">
    <div class="flex-box" style="border: 1px solid #E0E0DD; background: #ffffff;">
        <div>
            <input class="filter-input" name="<?=$field->title()?>_min" value="<?=$src[$field->title().'_length']?>"  type="number" placeholder=" " />
        </div>
    </div>
    <div>
        -
    </div>
    <div class="flex-box" style="border: 1px solid #E0E0DD;  background: #ffffff;">
        <div>
            <input class="filter-input" name="<?=$field->title()?>_max" value="<?=$src[$field->title().'_width']?>"  type="number" placeholder=" " />
        </div>
    </div>
    <div>
        <?// ?>
    </div>
</div>
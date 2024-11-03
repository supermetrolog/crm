
<?if(!$arr_value){
    $arr_value = ['',''];
}?>
<div class="flex-box">
    <div class="flex-box" >
        <div style="border: 1px solid #E0E0DD; background: #ffffff; ">
            <input style="width: 180px !important" class="filter-input" type="tel" min="0" name="<?=$field->title()?>[]" value="<?= $arr_value[0] ? $arr_value[0]  :  ''?>"   placeholder=" " />
        </div>
    </div>
    <div>

    </div>
    <div class="flex-box" >
        <div style="border: 1px solid #E0E0DD;  background: #ffffff;">
            <input style="width: 50px !important" class="filter-input" min="0" name="<?=$field->title()?>[]" value="<?=($arr_value[1]) ? $arr_value[1] : ''?>"  type="number" placeholder=" " />
        </div>
    </div>
</div>

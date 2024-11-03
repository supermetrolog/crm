<div class="filter-body">
    <div class="flex-box" >
        <div class="flex-box flex-vertical-center" style="border: 1px solid #E0E0DD; padding: 5px; background: #ffffff ">
            <div class="box-wide">
                <?=$filter->title()?>
            </div>
            <div>
                <div class="toggle-item flex-box">
                     <div class="toggle-bg">
                         <input class="filter-input" name="<?=trim($filter->filterName())?>" type="radio"  value="0">
                         <input class="filter-input" name="<?=trim($filter->filterName())?>" type="radio" <?=($_POST[trim($filter->filterName())] == 1 ) ? 'checked' : '';?> value="1">
                         <div class="filler"></div>
                         <div class="switch"></div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
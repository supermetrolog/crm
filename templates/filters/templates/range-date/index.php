<div class="filter-body">
    <div class="ghost">
        <?= $filter->title()?>
    </div>
    <div class="flex-box">
        <div class="flex-box" style="border: 1px solid #E0E0DD; background: #ffffff;">
            <div class="box-wide">
                от
            </div>
            <div>
                <input class="filter-input" name="<?=trim($filter->filterName())?>_min" value="<?=$_POST[trim($filter->filterName()).'_from']?>"  type="date" placeholder=" " />
            </div>
        </div>
        <div class="flex-box" style="border: 1px solid #E0E0DD;  background: #ffffff;">
            <div class="box-wide">
                до
            </div>
            <div>
                <input class="filter-input" name="<?=trim($filter->filterName())?>_max" value="<?=$_POST[trim($filter->filterName()).'_to']?>"  type="date" placeholder=" " />
            </div>
        </div>
        <div>
            <?=$filter->filterDimension() ?>
        </div>
    </div>
</div>
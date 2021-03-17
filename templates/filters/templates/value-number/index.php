<div class="filter-body">
    <div class="ghost">
        <?= $filter->title()?>
    </div>
    <div class="flex-box">
        <div class="flex-box" style="border: 1px solid #E0E0DD; background: #FFFFFF">
            <div class="box-wide">
                <?if(trim($filter->filterName()) == 'power'){?>
                    не менее
                <?}else{?>
                    не более
                <?}?>
            </div>
            <div>
                <input class="filter-input" name="<?=trim($filter->filterName())?>" value="<?=$_POST[trim($filter->filterName()).'_from']?>"  type="number" placeholder=" " />
            </div>
        </div>
        <div>
            <?=$filter->filterDimension() ?>
        </div>
    </div>
</div>
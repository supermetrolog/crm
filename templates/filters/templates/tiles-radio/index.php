<div class="filter-body">
    <div class="ghost filter-title">
        <?= $filter->title()?>
    </div>
    <div class="flex-box flex-wrap">
        <?
        foreach($filter->getFilterVariants() as $filter_item_unit){?>
            <div class="filter-variant">
                <div class="radio-container">
                    <input id="<?=$filter->filterName()?>-<?=$filter_item_unit['id']?>" name="<?=trim($filter->filterName())?>" type="radio" value="<?=$filter_item_unit['id']?>" <?=($filter_item_unit['id'] == $_POST[trim($filter->filterName())]) ? 'checked' : '' ;?>/>
                    <label for="<?=$filter->filterName()?>-<?=$filter_item_unit['id']?>">
                        <div class="checkmark tap-btn">
                            <?if($filter_item_unit['icon']){?>
                                <?=$filter_item_unit['icon']?>
                            <?}?>
                            <?=$filter_item_unit['title']?>
                        </div>
                    </label>
                </div>
            </div>
        <?}?>
    </div>
</div>
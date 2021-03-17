


<div class="filter-body tabs-block">
    <div class="ghost filter-title">
        <?= $filter->title()?>
    </div>
    <div class="flex-box flex-wrap tabs">
        <div class="filter-variant box-small-wide tab" style="padding: 5px; border: 0">
            <div class="radio-container">
                <input id="<?=$filter->filterName()?>-0" name="<?=trim($filter->filterName())?>" type="radio" value="0"/>
                <label class="pointer" for="<?=$filter->filterName()?>-0">
                    <div class="checkmark-light">
                        Все
                    </div>
                </label>
            </div>
        </div>
        <?
        foreach($filter->getFilterVariants() as $filter_item_unit){?>
            <?if($filter_item_unit['exclude'] != 1){?>
                <div class="filter-variant box-small-wide tab" style="padding: 5px; border: 0">
                    <div class="radio-container">
                        <input id="<?=$filter->filterName()?>-<?=$filter_item_unit['id']?>" name="<?=trim($filter->filterName())?>" type="radio" value="<?=$filter_item_unit['id']?>" <?=($filter_item_unit['id'] == $_POST[trim($filter->filterName())]) ? 'checked' : '' ;?>/>
                        <label class="pointer" for="<?=$filter->filterName()?>-<?=$filter_item_unit['id']?>">
                            <div class="checkmark-light" >
                                <?if($filter_item_unit['icon']){?>
                                    <?=$filter_item_unit['icon']?>
                                <?}?>
                                <?=$filter_item_unit['title']?>
                            </div>
                        </label>
                    </div>
                </div>
            <?}?>
        <?}?>
    </div>
    <div class="tabs-content">
        <div class="tab-content" >
            4543545435454543
        </div>
        <div class="tab-content" >
            dfdfdf
        </div>
        <div class="tab-content" >
            1112121
        </div>
        <div class="tab-content" >
            3434
        </div>
    </div>
</div>
<div class="filter-body">
    <?if($filter->showTitle()){?>
        <div class="ghost">
            <?= $filter->title()?>
        </div>
    <?}?>
    <div class="flex-box flex-center  flex-wrap">
        <?foreach($filter->getFilterVariants() as $filter_item_unit){?>
            <div class="filter-variant" title="<?=$filter_item_unit['title']?>">
                <div class="radio-container">
                    <input id="<?=$filter->filterName()?>-<?=$filter_item_unit['id']?>" name="<?=trim($filter->filterName())?>[]" type="checkbox" value="<?=$filter_item_unit['id']?>" <?=(in_array($filter_item_unit['id'],$_POST[trim($filter->filterName())])) ? 'checked' : '' ;?>/>
                    <label for="<?=$filter->filterName()?>-<?=$filter_item_unit['id']?>" >
                        <div class="checkmark tap-btn">
                            <?if(trim($filter->filterName()) == 'purposes'){?>
                                <div style="min-width: 28px; padding: 5px 0; color: white; font-size: 20px;">
                                    <?if($filter_item_unit['icon']){?>
                                        <?=$filter_item_unit['icon']?>
                                    <?}?>
                                </div>
                            <?}else{?>
                                <div class="flex-box-inline">
                                    <?if($filter_item_unit['icon']){?>
                                        <?=$filter_item_unit['icon']?>
                                    <?}?>
                                </div>
                                <?=$filter_item_unit['title']?>
                            <?}?>
                        </div>
                    </label>
                </div>
            </div>
        <?}?>
    </div>
</div>
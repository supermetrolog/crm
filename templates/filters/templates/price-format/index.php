<div class="filter-body">
    <div class="ghost filter-title">
        <?= $filter->title()?>
    </div>
    <div class="flex-box flex-wrap">
        <?
        $i = 1;
        foreach($filter->getFilterVariants() as $filter_item_unit){?>
            <?if(((in_array($filters_arr->object_type,json_decode($filter_item_unit['object_type'])) != NULL || $filters_arr->safe_type) && in_array($filters_arr->deal_type,json_decode($filter_item_unit['deal_type'])) != NULL)  ){?>
                <div class="filter-variant">
                    <div class="radio-container">
                        <input id="<?=$filter->filterName()?>-<?=$filter_item_unit['id']?>" name="<?=trim($filter->filterName())?>" type="radio" value="<?=$filter_item_unit['id']?>" <?=($filter_item_unit['id'] == $_POST[trim($filter->filterName())] || $i == 1) ? 'checked' : '' ;?>/>
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
                <?$i++;?>
             <?}?>
        <?}?>
    </div>
</div>
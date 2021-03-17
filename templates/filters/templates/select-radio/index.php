<div class="filter-body">
    <?if($filter->showTitle()){?>
        <div class="ghost">
            <?= $filter->title()?>
        </div>
    <?}?>
    <div class="custom-select" title="<?=$filter->title()?>">
        <div style="" class="custom-select-header <?= ($filter->titleFilled()) ? 'select-title-filled' : 'select-title-underline';?> flex-box pointer">
            <div class="box-wide " >
                <?if($_POST[$filter->filterName()]){?>
                    <?$selected = new Post($_POST[$filter->filterName()]);?>
                    <?$selected->getTable($filter->filterVariantsTable());?>
                    <?=$selected->title()?>
                <?}else{?>
                    <?=$filter->title()?>
                <?}?>
            </div>
            <div class="to-end">
                <i class="fas fa-caret-down"></i>
            </div>
        </div>
        <div class="custom-select-body custom-select-body-radio" >
            <ul class="custom-select-list">
                <?foreach($filter->getFilterVariants() as $filter_item_unit){?>
                    <li class="<?= ( $filter_item_unit['id'] != $_POST[trim($filter->filterName())])? '' :'hidden';?>">
                        <div>
                            <input id="<?=$filter->filterName().'-'.$filter_item_unit['id']?>" <?= ($filter_item_unit['id'] == $_POST[trim($filter->filterName())]) ? 'checked="checked"' : ''?> value="<?=$filter_item_unit['id']?>" name="<?=trim($filter->filterName())?>" type="radio" />
                            <label  title="<?=$filter_item_unit['title']?>" id="label-<?=$filter->filterName().'-'.$filter_item_unit['id']?>" style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer " for="<?=$filter->filterName().'-'.$filter_item_unit['id']?>">
                                <div>
                                    <?=$filter_item_unit['title']?>
                                </div>
                                <div class="to-end">
                                    <i class="fas fa-check"></i>
                                </div>
                            </label>
                        </div>
                    </li>
                <?}?>
            </ul>
        </div>
    </div>
</div>

<div class="filter-body">
    <?if($filter->showTitle()){?>
        <div class="ghost">
            <?= $filter->title()?>
        </div>
    <?}?>
    <div class="custom-select " title="<?=$filter->title()?>">
        <div class="flex-box" style="color: white;">
            <div>
                <i class="fas fa-map-marker-alt"></i>
            </div>
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
        </div>
        <div class="custom-select-body custom-select-body-radio" >
            <ul class="custom-select-list">
                <li>
                    <div>
                        <input id="<?=$filter->filterName().'-'?>1000"  value="1000" name="<?=trim($filter->filterName())?>" type="radio" />
                        <label  title="Вся Россия" id="label-<?=$filter->filterName().'-'?>1000" style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer " for="<?=$filter->filterName().'-'?>1000">
                            <div>
                                Вся Россия
                            </div>
                            <div class="to-end">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                    </div>
                </li>
                <li>
                    <div>
                        <input id="<?=$filter->filterName().'-'?>100"  value="100" name="<?=trim($filter->filterName())?>" type="radio" />
                        <label  title="Москва и МО" id="label-<?=$filter->filterName().'-'?>100" style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer " for="<?=$filter->filterName().'-'?>100">
                            <div>
                                Москва и МО
                            </div>
                            <div class="to-end">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                    </div>
                </li>
                <li>
                    <div>
                        <input id="<?=$filter->filterName().'-'?>200"  value="200" name="<?=trim($filter->filterName())?>" type="radio" />
                        <label  title="Москва внутри МКАД" id="label-<?=$filter->filterName().'-'?>200" style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer " for="<?=$filter->filterName().'-'?>200">
                            <div>
                                Москва внутри МКАД
                            </div>
                            <div class="to-end">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                    </div>
                </li>
                <li>
                    <div>
                        <input id="<?=$filter->filterName().'-'?>300"  value="300" name="<?=trim($filter->filterName())?>" type="radio" />
                        <label  title="МО + Москва снаружи МКАД" id="label-<?=$filter->filterName().'-'?>300" style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer " for="<?=$filter->filterName().'-'?>300">
                            <div>
                                МО + Москва снаружи МКАД
                            </div>
                            <div class="to-end">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                    </div>
                </li>
                <li>
                    <div>
                        <input id="<?=$filter->filterName().'-'?>400"  value="400" name="<?=trim($filter->filterName())?>" type="radio" />
                        <label  title="МО + регионы рядом" id="label-<?=$filter->filterName().'-'?>400" style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer " for="<?=$filter->filterName().'-'?>400">
                            <div>
                                МО + регионы рядом
                            </div>
                            <div class="to-end">
                                <i class="fas fa-check"></i>
                            </div>
                        </label>
                    </div>
                </li>
                <?foreach($filter->getFilterVariants() as $filter_item_unit){?>
                    <li class="<?= ( $filter_item_unit['id'] != $_POST[trim($filter->filterName())])? '' :'hidden';?>">
                        <div>
                            <input id="<?=$filter->filterName().'-'.$filter_item_unit['id']?>"  value="<?=$filter_item_unit['id']?>" name="<?=trim($filter->filterName())?>" type="radio" />
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

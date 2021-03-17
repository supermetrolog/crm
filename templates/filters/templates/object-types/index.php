<div class="filter-body  tabs-block">
    <div class="flex-box flex-center flex-wrap tabs">
        <div class="filter-variant " style="border: none; padding: 0; position: relative;">
            <div class="radio-container">
                <input id="<?=$filter->filterName()?>-0" name="<?=trim($filter->filterName())?>" type="radio" value="0" />
                <label class="tab" for="<?=$filter->filterName()?>-0">
                    <div class="checkmark tap-btn" >
                        <i class="fas fa-globe-americas"></i>
                        Все объекты
                    </div>
                </label>
            </div>
        </div>
        <?foreach($filter->getFilterVariants() as $filter_item_unit){?>
            <?if($filter_item_unit['id'] != 2){?>
                <div class="filter-variant  " style="border: none; padding: 0; position: relative;">
                    <div class="radio-container">
                        <input id="<?=$filter->filterName()?>-<?=$filter_item_unit['id']?>" name="<?=trim($filter->filterName())?>" type="radio" value="<?=$filter_item_unit['id']?>" <?=($filter_item_unit['id'] == $_POST[trim($filter->filterName())]) ? 'checked' : '' ;?>/>
                        <label class="tab" for="<?=$filter->filterName()?>-<?=$filter_item_unit['id']?>">
                            <div class="checkmark tap-btn " >
                                <?if($filter_item_unit['icon']){?>
                                    <?=$filter_item_unit['icon']?>
                                <?}?>
                                <?if($filter_item_unit['id'] == 1){?>
                                    Строение
                                <?}else{?>
                                    <?=$filter_item_unit['title']?>
                                <?}?>
                            </div>
                        </label>
                    </div>

                </div>
            <?}?>
        <?}?>
    </div>
    <?php
    $types = [1,2];

    $filter = new Filter(45);
    ?>
    <div class="tabs-content box">
        <div class="tab-content">

        </div>
        <?//foreach ($types as $type){?>
            <div class="tab-content">
                <div class="flex-box flex-around flex-wrap" style="width: 800px;">
                    <?foreach ($types as $type){?>
                        <div class="flex-box box-small">
                            <?
                            $sql = $pdo->prepare("SELECT * FROM l_purposes WHERE type=$type   ");
                            $sql->execute();
                            while($purpose = $sql->fetch(PDO::FETCH_LAZY)){?>
                                <?$filter_item_unit = $purpose;?>
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
                                                <?}?>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            <?}?>
                        </div>
                    <?}?>
                </div>
            </div>
            <div class="tab-content">
                <?
                $sql = $pdo->prepare("SELECT * FROM l_purposes WHERE type=3   ");
                $sql->execute();
                while($purpose = $sql->fetch(PDO::FETCH_LAZY)){?>
                    <?$filter_item_unit = $purpose;?>
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
                                    <?}?>
                                </div>
                            </label>
                        </div>
                    </div>
                <?}?>
            </div>
        <?//}?>
    </div>
</div>
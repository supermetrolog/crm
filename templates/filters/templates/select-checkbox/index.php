<div class="filter-body">
    <?if($filter->showTitle()){?>
        <div class="ghost">
            <?= $filter->title()?>
        </div>
    <?}?>
    <div class="custom-select" title="<?=$filter->title()?>">
        <div class="custom-select-header <?= ($filter->titleFilled()) ? 'select-title-filled' : 'select-title-underline';?> flex-box pointer">
                <?if($filter->showField('filter_header_sign')){?>
                    <div>
                        <?=$filter->showField('filter_header_sign')?>
                    </div>
                <?}?>
                <div class="box-wide ">
                    <?if($_POST[trim($filter->filterName())] != NULL){
                        $select_line = '';
                        foreach ($_POST[trim($filter->filterName())] as $selected){
                            $selected = new Post($selected);
                            $selected->getTable($filter->filterVariantsTable());
                            $select_line = $select_line.', '.$selected->title();
                        }
                        $select_arr = explode(',',trim($select_line,','));
                        if(count($select_arr) > 2 ){
                            $select_line =  $select_arr[0].', '.$select_arr[1].' + еще '.(count($select_arr) - 2);
                        }elseif(count($select_arr) > 1){
                            $select_line = $select_arr[0].', '.$select_arr[1];
                        }else{
                            $select_line = $select_arr[0];
                        }
                    ?>
                        <?=$select_line?>
                    <?}else{?>
                        <?=$filter->title()?>
                    <?}?>
                </div>
                <div class="to-end">
                    <i class="fas fa-caret-down"></i>
                </div>
        </div>
        <div class="custom-select-body" >
            <ul class="custom-select-list">
                <?foreach($filter->getFilterVariants() as $filter_item_unit){?>
                    <?if( $filter_item_unit['id'] != $_POST[trim($filter->filterName())]){?>
                        <li>
                            <div>
                                <input id="<?=$filter->filterName().'-'.$filter_item_unit['id']?>" <?= (in_array($filter_item_unit['id'],$_POST[trim($filter->filterName())]))? 'checked="checked"' : ''?> value="<?=$filter_item_unit['id']?>" name="<?=trim($filter->filterName())?>[]" type="checkbox" />
                                <label title="<?=$filter_item_unit['title']?>" id="label-<?=$filter->filterName().'-'.$filter_item_unit['id']?>" style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer" for="<?=$filter->filterName().'-'.$filter_item_unit['id']?>">
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
                <?}?>
            </ul>
        </div>
    </div>
</div>

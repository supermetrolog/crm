<div class="filter-body">
    <div class="custom-select" title="<?=$field->description()?>">
        <div class="custom-select-header select-title-filled flex-box pointer <?=(json_decode($src[$field->title()])[0] != NULL)  ? 'input-filled' :''?>">
            <div class="box-wide ">
                <?if(json_decode($src[$field->title()])[0] != NULL){?>
                    <?//if(1 ==2){?>
                    <?
                    $select_line = '';
                    foreach (json_decode($src[$field->title()]) as $selected){
                        $selected = new Post($selected);
                        $selected->getTable($field->getField('linked_table'));
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
                    <?=$field->description()?>
                <?}?>
            </div>
            <div class="to-end">
                <i class="fas fa-caret-down"></i>
            </div>
        </div>
        <div class="custom-select-body" >
            <ul class="custom-select-list">
                <?
                $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table')."");
                $sql->execute();
                //foreach($filter->getFilterVariants() as $filter_item_unit){
                while($sql_src = $sql->fetch(PDO::FETCH_LAZY)){?>
                    <? //if( $filter_item_unit['id'] != $_POST[trim($filter->filterName())]){?>
                    <li>
                        <div>
                            <input id="<?=$field->title().'-'.$sql_src['id']?>" <?= (in_array($sql_src['id'], json_decode($src[$field->title()])))? 'checked="checked"' : ''?> value="<?=$sql_src['id']?>" name="<?=trim($field->title())?>[]" type="checkbox" />
                            <label title="" id="label-<?=$field->title().'-'.$sql_src['id']?>" style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer" for="<?=$field->title().'-'.$sql_src['id']?>">
                                <div>
                                    <?=$sql_src['title']?>
                                </div>
                                <div class="to-end">
                                    <i class="fas fa-check"></i>
                                </div>
                            </label>
                        </div>
                    </li>
                <?}?>
                <?//}?>
            </ul>
        </div>
    </div>
</div>
<div class=" flex-box flex-vertical-top flex-around">
    <?
    $items = $pdo->prepare("SELECT * FROM ".$filter->getField('linked_table')." ORDER BY title ASC ");
    $items->execute();
    $arr = $items->fetchAll();
    $amount = count($arr);
    $col_amount = $amount/5;
    $curr_num = 1;
    for($col_num = 1; $col_num <= 5; $col_num++){?>
        <div>
            <?for($i = $curr_num; $i < $curr_num + $col_amount; $i++){?>
                <div class="flex-box flex-vertical-top">
                    <div class="box-wide" style="width: 30px;">
                        <h2 >
                            <?if($last_title !== preg_split('//u',$arr[$i]['title'],-1,PREG_SPLIT_NO_EMPTY)[0]){?>
                                <?=mb_strtoupper(preg_split('//u',$arr[$i]['title'],-1,PREG_SPLIT_NO_EMPTY)[0])?>
                            <?}else{?>
                                -
                            <?}?>
                        </h2>
                    </div>
                    <div class="toggle-checkbox">
                        <input id="highways_moscow-<?=$arr[$i]['id']?>" value="<?=$arr[$i]['id']?>" name="<?=trim($filter->filterName())?>[]" <?=(in_array($arr[$i]['id'],$_POST[trim($filter->filterName())])) ? 'checked' : '' ;?> type="checkbox"/>
                        <label for="highways_moscow-<?=$arr[$i]['id']?>"  style="color: black !important;">
                            <div class="text_left box-wide">
                                <?=$arr[$i]['title']?>
                                <?if($arr[$i]['town_type']){?>
                                    <br>
                                    <?
                                    $town_type = new Post($arr[$i]['town_type']);
                                    $town_type->getTable('l_towns_types');
                                    ?>
                                    <span class="ghost"><?=$town_type->title()?></span>
                                <?}?>

                                <?if($arr[$i]['town_district']){?>
                                    <?
                                    $town_district = new Post($arr[$i]['town_district']);
                                    $town_district->getTable('l_districts');
                                    ?>
                                    <span class="ghost">(<?=$town_district->title()?>)</span>
                                <?}?>
                            </div>
                        </label>
                    </div>
                    <?$last_title = preg_split('//u',$arr[$i]['title'],-1,PREG_SPLIT_NO_EMPTY)[0]?>
                </div>
            <?}?>
        </div>
        <?$curr_num = $col_num*$col_amount?>
    <?}?>
</div>
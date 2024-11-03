<div class="flex-box field-module">
    <div class="flex-box flex-wrap field-step-1">
        <div class="toggle-checkbox yes-value" style="margin: 3px;">
            <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-1" value="1" name="<?=trim($field->title())?>" <?=(1 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
            <label for="<?=trim($field->title())?>-1">
                да
            </label>
        </div>
        <div class="toggle-checkbox no-value" style="margin: 3px;">
            <input <?if($field->getField('field_required')){?> required <?}?> id="<?=trim($field->title())?>-2" value="2" name="<?=trim($field->title())?>" <?=(2 == $src[$field->title()]) ? 'checked' : '' ;?> type="radio"/>
            <label for="<?=trim($field->title())?>-2">
                нет
            </label>
        </div>
    </div>
    <div class="field-step-2 <?if($src[$field->title()] != 1){?> hidden <?}?>">
        <div class="filter-body">
            <div class="custom-select" title="<?=$field->description()?>">
                <div class="custom-select-header select-title-filled flex-box pointer <?=(json_decode($src[$field->title().'_type'])[0] != NULL)  ? 'input-filled' :''?>">
                    <div class="">
                        <?if(json_decode($src[$field->title().'_type'])[0] != NULL){?>
                            <?
                            $select_line = '';
                            foreach (json_decode($src[$field->title().'_type']) as $selected){
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
                        <li>
                            <input type="hidden" name="<?=trim($field->title().'_type')?>" value="0" />
                        </li>
                        <?
                        $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table')."");
                        $sql->execute();
                        while($sql_src = $sql->fetch(PDO::FETCH_LAZY)){?>
                            <li>
                                <div>
                                    <input   id="<?=$field->title().'_type'.'-'.$sql_src['id']?>" <?= (in_array($sql_src['id'], json_decode($src[$field->title().'_type'])))? 'checked="checked"' : ''?> value="<?=$sql_src['id']?>" name="<?=trim($field->title().'_type')?>[]" type="checkbox" />
                                    <label title="" id="label-<?=$field->title().'-'.$sql_src['id']?>" style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer" for="<?=$field->title().'_type'.'-'.$sql_src['id']?>">
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
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
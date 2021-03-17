<?if($field->getField('insert_type') == 'manual'){ /*-----------если это ввод текста----------------------------------*/?>
    <?if($field->getField('field_input_type') == 'fulltext'){?>
        <textarea name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?>  placeholder=' '><?=($src[$field->title()])? $src[$field->title()] : ''; ?></textarea>
    <?}elseif($field->showField('field_input_type') == 'address'){?>
        <input type='text' id="address"  name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?>  placeholder=' ' value='<?=($src[$field->title()])? $src[$field->title()] : ''; ?>'/>
    <?}else{?>
        <input type='<?=$field->getField('field_input_type')?>' name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?>  placeholder=' ' value='<?=($src[$field->title()])? $src[$field->title()] : ''; ?>'/>
    <?}?>
<?}elseif($field->getField('insert_type') == 'hidden'){ /*---------------------если это селект-------------------------*/?>
    <input type='hidden'  name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?>  value='<?=($src[$field->title()])? $src[$field->title()] : ''; ?>'/>
<?}elseif($field->getField('insert_type') == 'select'){ /*---------------------если это селект-------------------------*/?>
    <select class="<?= (trim($src[$field->title()])) ? 'field-checked' :'' ?>" <?=($field->getField('field_required') ? 'required' : '')?> name='<?=$field->title()?>'>
        <?
        if(trim($src[$field->title()])){
            $table_post = new Post($src[$field->title()]);
            $table_post->getTable($field->getField('linked_table'));
            echo "<option value='".$table_post->postId()."'>".$table_post->title()."</option>";
        }else{
            echo "<option value=''>Выберите</option>";
        }
        $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table')."");
        $sql->execute();
        while($sql_src =$sql->fetch(PDO::FETCH_LAZY)){
            echo "<option value='".$sql_src->id."'>".$sql_src->title."</option>";
        }
        ?>
    </select>
<?}elseif($field->getField('insert_type') == 'tableselect'){ /*---------------------если это выбор таблицы-------------------------*/?>
    <select name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?> >
        <?
        if($src[$field->title()] != ''){
            echo "<option value='".$src[$field->title()]."'>".$src[$field->title()]."</option>";
        }
        $sql= $pdo->prepare("SHOW TABLES FROM $db");
        $sql->execute();
        while($table = $sql->fetch()){?>
            <option value='<?=$table["Tables_in_$db"]?>'><?=$table["Tables_in_$db"]?></option>
        <?}?>
    </select>
<?}elseif($field->getField('insert_type') == 'multiselect'){ /* ------------если это множественный селект---------------*/?>
    <select multiple name='<?=$field->title()?>[]' <?=($field->getField('field_required') ? 'required' : '')?>  >
        <?
        $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table'));
        $sql->execute();
        while($sql_src = $sql->fetch(PDO::FETCH_LAZY)){
            in_array($sql_src->id, json_decode($src[$field->title()])) ? $selected = "style='background: rgba(220,220,220, 1);'" : $selected ='';
            echo "<option $selected value='".$sql_src->id."'>".$sql_src->title."</option>";
        }
        ?>
    </select><br>
<?}elseif($field->getField('insert_type') == 'select-checkbox'){ /* ------------если это множественный селект---------------*/?>
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
<?}elseif($field->getField('insert_type') == 'tiles-checkbox'){ /* ------------если это множественный селект---------------*/?>
    <div class="flex-box flex-wrap">
        <?foreach($field->getFieldVariants() as $field_item){
            ?>
            <div class="toggle-checkbox" style="margin: 3px;">
                <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],json_decode($src[$field->title()]))) ? 'checked' : '' ;?> type="checkbox"/>
                <label for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                    <?=$field_item['title_short']?>
                </label>
            </div>
        <?}?>
    </div>
<?}elseif($field->getField('insert_type') == 'datalist'){ /* ------------если это множественный datalist---------------*/?>
    <?
    if($src[$field->title()] != ''){
        $table_post = new Post($src[$field->title()]);
        $table_post->getTable($field->getField('linked_table'));
        $field_value = $table_post->title();
    }
    ?>
    <input class="hidden"  name="<?=$field->title()?>" list="<?=$field->title()?>" type="text" placeholder="<?=$field_value?>" value='<?=$src[$field->title()]?>' />
    <datalist id="<?=$field->title()?>">
        <?
        $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table'));
        $sql->execute();
        while($sql_src = $sql->fetch(PDO::FETCH_LAZY)){?>
            <option label="<?=$sql_src->title?>" value="<?=$sql_src->id?>" />
        <? } ?>
    </datalist>
<?}elseif($field->getField('insert_type') == 'radio'){ /* ------------если это множественный radio---------------*/?>
    <div class="box">
        <div class="box">
            <?
            $vars_arr = explode(',',$field->getField('input_vars'));
            foreach ($vars_arr as $radio_var){?>
                <label class="radio-container">
                    <input <?=($src[$field->title()] == $radio_var)? 'checked' : '';?> type="radio" value="<?=$radio_var?>" name="<?=$field->title()?>" /><?=$radio_var?>
                    <span class="checkmark"></span>
                </label>
            <?}?>
        </div>
    </div>
<?}elseif($field->getField('insert_type') == 'tumbler'){?>
    <div>
        <div class="toggle-item flex-box flex-vertical-center">
            <div class="toggle-bg">
                <input type="radio" name="<?=$field->title()?>" value="0">
                <input type="radio" name="<?=$field->title()?>" <?=($src[$field->title()] == 1 ) ? 'checked' : '';?> value="1">
                <div class="filler"></div>
                <div class="switch"></div>
            </div>
        </div>
    </div>
<?}elseif($field->getField('insert_type') == 'tumbler-value'){?>
    <div class="flex-box flex-vertical-center">
        <div>
            <div class="toggle-item flex-box flex-vertical-center">
                <div class="toggle-bg">
                    <input type="radio" name="<?=$field->title()?>" value="0">
                    <input type="radio" name="<?=$field->title()?>" <?=($src[$field->title()] == 1 ) ? 'checked' : '';?> value="1">
                    <div class="filler"></div>
                    <div class="switch"></div>
                </div>
            </div>
        </div>
        <div>
            <input type='number' name='<?=$field->title()?>_value' <?=$field->getField('require_type')?>  placeholder='<?=$field->description()?>' value='<?=($src[$field->title().'_value'])? $src[$field->title().'_value'] : ''; ?>'/>
        </div>
    </div>
<?}elseif($field->showField('insert_type') == 'multifield'){ /*---------------------если это выбор таблицы-------------------------*/?>
    <div class="flex-box">
        <div class="multifield-container">

            <?if(trim($placeholder = $field->getField('field_placeholder'))){?>
                <?$placeholder = 'title="'.$placeholder.'"';?>
            <?}else{?>
                <?$placeholder ='';?>
            <?}?>

            <?if(trim($pattern = $field->getField('field_pattern'))){?>
                <?$pattern = 'pattern="'.$placeholder.'"';?>
            <?}else{?>
                <?$pattern ='';?>
            <?}?>
            <?if( $fields = json_decode($src[$field->title()])[0] != NULL){?>
                <?foreach (json_decode($src[$field->title()]) as $item){?>
                    <?if($item){?>
                        <input placeholder=' ' <?=$placeholder?>  type="<?=$field->getField('field_input_type')?>" name="<?=$field->title()?>[]" value='<?=$item?>' /><br>
                    <?}?>
                <?}?>
            <?}else{?>
                <input placeholder=' ' <?=$placeholder?>  type="<?=$field->getField('field_input_type')?>" name="<?=$field->title()?>[]"  /><br>
            <?}?>
        </div>
        <div title="Добавить поле" class="icon-round to-end more-fields pointer">+</div>
    </div>

<?}elseif($field->getField('insert_type') == 'rating'){?>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <div class="star-rating">
        <div class="star-rating__wrap">
            <?php
            $rating = new Post(0);
            $rating->getTable('rating_points');
            foreach ($rating->getAllUnitsReverse() as $raiting_unit){?>
                <input <?=($post->rating() == $raiting_unit['id'])? 'checked' : ''?> class="star-rating__input" id="star-rating-<?=$raiting_unit['id']?>" type="radio" name="rating" value="<?=$raiting_unit['id']?>">
                <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-<?=$raiting_unit['id']?>" title="<?=$raiting_unit['title']?>"></label>
            <?}?>
        </div>
    </div>
<?}elseif($field->getField('insert_type') == 'range'){?>
    <div class="flex-box">
        <div class="flex-box" style="border: 1px solid #E0E0DD; background: #ffffff;">
            <div>
                <input class="filter-input" name="<?=$field->title()?>_min" value="<?=$src[$field->title().'_min']?>"  type="number" placeholder=" " />
            </div>
        </div>
        <div>
            -
        </div>
        <div class="flex-box" style="border: 1px solid #E0E0DD;  background: #ffffff;">
            <div>
                <input class="filter-input" name="<?=$field->title()?>_max" value="<?=$src[$field->title().'_max']?>"  type="number" placeholder=" " />
            </div>
        </div>
        <div>
            <?// ?>
        </div>
    </div>
<?}elseif($field->getField('insert_type') == 'photos'){?>
    <div class="form-files files-field-<?=$field->title()?> ">
        <?if($post->id > 0){?>
            <div class="draggable">
                <? if($post->showJsonField($field->title()) != NULL){?>
                    <?foreach($post->showJsonField($field->title()) as $file_unit){?>
                        <div class='form-file'>
                            <img src='<?=$file_unit?>'/>
                            <div class="file-delete" data-field="<?=$field->title()?>">
                                <i class='fa fa-times' aria-hidden='true'></i>
                            </div>
                        </div>
                    <?}?>
                <?}?>
            </div>
            <div>
                <input id="form_element_<?=$field->title()?>" type="file" class="file-input"  name="<?=$field->title()?>[]" value=""  accept="image/*,image/jpeg">
                <label for="form_element_<?=$field->title()?>">загрузить <?=$field->description()?></label>
            </div>

            <?if($post->showJsonField($field->title()) != NULL){ ?>
                <div class='photo_resort' data-field="<?=$field->title()?>">
                    <i class="fas fa-save"></i>
                </div>
            <?}?>
        <?}?>
        <script>
            $(document).ready( function() {
                $('body').on('input', '.files-field-<?=$field->title()?>  input:last', function () {
                    alert('последний');
                    $(this).closest('.form-files').append('<input type="file" class="file-input"   name="<?=$field->title()?>[]" multiple="" accept="image/*,image/jpeg">')
                });
            });
        </script>
        <div class="card-photos-grid draggable flex-box flex-wrap">
            <? $i = 1;

            $table_obj = new Table(0);
            $table_obj->getTableByName($_GET['table']);
            $photodir = $_SERVER['DOCUMENT_ROOT']."/uploads/".$table_obj->getField('table_directory')."/".$src['id']."/";
            $photos = scandir($photodir);
            //echo $photodir;
            //var_dump($photos);
            //echo $_SERVER['DOCUMENT_ROOT']."data/images/c_industry/$object_id/";
            //var_dump($photos);
            foreach($photos as $thumb){
                //foreach($object->thumbs() as $thumb){
                $thumb = trim($thumb,'.');
                if(stristr($thumb, 'del') === FALSE &&  $thumb != NULL){?>
                    <div class="flex-box">
                        <div class="flex-box flex-around background-fix" style="background-image: url(<?=PROJECT_URL.'/'."uploads/objects/".$src['id']."/".$thumb?>) " >
                            <?if($i > 14){?>
                                <div class="isBold" style="font-size: 30px; color: white; cursor: pointer; text-shadow: 1px 1px 2px black, 0 0 1em #000000;  ">
                                    +<?=(count($photos) - $i)?>
                                </div>
                            <?}?>
                        </div>
                    </div>
                    <?$i++;}?>
                <?if($i > 15){break;}?>
            <?}?>
        </div>
    </div>
<?}elseif($field->getField('insert_type') == 'files'){?>
    <div class="form-files files-field-<?=$field->title()?> ">
        <?if($post->id > 0){?>
            <div class="draggable">
                <? if($post->showJsonField($field->title()) != NULL){?>
                    <?foreach($post->showJsonField($field->title()) as $file_unit){?>
                        <div class='form-file'>
                            <img src='<?=$file_unit?>'/>
                            <div class="file-delete" data-field="<?=$field->title()?>">
                                <i class='fa fa-times' aria-hidden='true'></i>
                            </div>
                        </div>
                    <?}?>
                <?}?>
            </div>
            <div>
                <input id="form_element_<?=$field->title()?>" type="file" class="file-input"  name="<?=$field->title()?>[]" value=""  accept="image/*,image/jpeg">
                <label for="form_element_<?=$field->title()?>">загрузить<br> <?=$field->description()?></label>
            </div>
            <?if($post->showJsonField($field->title()) != NULL){ ?>
                <div class='photo_resort' data-field="<?=$field->title()?>">
                    <i class="fas fa-save"></i>
                </div>
            <?} ?>
        <?}?>

        <script>
            $(document).ready( function() {
                $('body').on('input', '.files-field-<?=$field->title()?>  input:last', function () {
                    alert('последний');
                    $(this).closest('.form-files').append('<input type="file" class="file-input"   name="<?=$field->title()?>[]" multiple="" accept="image/*,image/jpeg">')
                });
            });
        </script>
    </div>
<?}else{?>

<?}?>
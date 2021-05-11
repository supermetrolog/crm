



<?if($field->showField('insert_type') == 'manual'){ /*-----------если это ввод текста----------------------------------*/?>
    <?if($field->showField('input_type') == 'fulltext'){?>
        <textarea name='<?=$field->title()?>' <?=$field->showField('require_type')?>  placeholder='<?=$field->description()?>'><?=($src[$field->title()])? $src[$field->title()] : ''; ?></textarea>
    <?}else{?>
        <input type='<?=$field->showField('input_type')?>' name='<?=$field->title()?>' <?=$field->showField('require_type')?>  placeholder='<?=$field->description()?>' value='<?=($src[$field->title()])? $src[$field->title()] : ''; ?>'/>
    <?}?>
<?}elseif($field->showField('insert_type') == 'select'){ /*---------------------если это селект-------------------------*/?>
    <select name='<?=$field->title()?>'>
        <?
        if($src[$field->title()] != ''){
            $table_post = new Post($src[$field->title()]);
            $table_post->getTable($field->showField('linked_table'));
            echo "<option value='".$table_post->postId()."'>".$table_post->title()."</option>";
        }
        $sql = $pdo->prepare("SELECT * FROM ".$field->showField('linked_table'));
        $sql->execute();
        while($sql_src =$sql->fetch(PDO::FETCH_LAZY)){
            echo "<option value='".$sql_src->id."'>".$sql_src->title."</option>";
        }
        ?>
    </select>
<?}elseif($field->showField('insert_type') == 'tableselect'){ /*---------------------если это выбор таблицы-------------------------*/?>
    <select name='<?=$field->title()?>'>
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
<?}elseif($field->showField('insert_type') == 'multiselect'){ /* ------------если это множественный селект---------------*/?>
    <select multiple name='<?=$field->title()?>[]'>
        <?
        $sql = $pdo->prepare("SELECT * FROM ".$field->showField('linked_table'));
        $sql->execute();
        while($sql_src = $sql->fetch(PDO::FETCH_LAZY)){
            in_array($sql_src->id, json_decode($src[$field->title()])) ? $selected = "style='background: rgba(220,220,220, 1);'" : $selected ='';
            echo "<option $selected value='".$sql_src->id."'>".$sql_src->title."</option>";
        }
        ?>
    </select><br>
<?}elseif($field->showField('insert_type') == 'tiles-checkbox'){ /* ------------если это множественный селект---------------*/?>
    <div class="flex-box">
        <?foreach($field->getFieldVariants() as $field_item){
            ?>
            <div class="toggle-checkbox">
                <input value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],json_decode($src[$field->title()]))) ? 'checked' : '' ;?> type="checkbox"/>
                <div>
                    <?=$field_item['icon']?>
                </div>
            </div>
        <?}?>
    </div>
<?}elseif($field->showField('insert_type') == 'datalist'){ /* ------------если это множественный datalist---------------*/?>
    <?
    if($src[$field->title()] != ''){
        $table_post = new Post($src[$field->title()]);
        $table_post->getTable($field->showField('linked_table'));
        $field_value = $table_post->title();
    }
    ?>
    <input name="<?=$field->title()?>" list="<?=$field->title()?>" type="<?=$field->showField('input_type')?>" placeholder="<?=$field_value?>" value='<?=$src[$field->title()]?>' />
    <span>(<?=$field_value?>)</span>
    <datalist id="<?=$field->title()?>">
        <?
        $sql = $pdo->prepare("SELECT * FROM ".$field->showField('linked_table'));
        $sql->execute();
        while($sql_src = $sql->fetch(PDO::FETCH_LAZY)){?>
            <option label="<?=$sql_src->title?>" value="<?=$sql_src->id?>" />
        <? } ?>
    </datalist>
<?}elseif($field->showField('insert_type') == 'radio'){ /* ------------если это множественный radio---------------*/?>
    <div class="box">
        <div class="box">
            <?
            $vars_arr = explode(',',$field->showField('input_vars'));
            foreach ($vars_arr as $radio_var){?>
                <label class="radio-container">
                    <input <?=($src[$field->title()] == $radio_var)? 'checked' : '';?> type="radio" value="<?=$radio_var?>" name="<?=$field->title()?>" /><?=$radio_var?>
                    <span class="checkmark"></span>
                </label>
            <?}?>
        </div>
    </div>
<?}elseif($field->showField('insert_type') == 'tumbler'){?>
    <div class="box">
                                <span class="toggle-item box">
                                    <span class="toggle-bg">
                                        <input type="radio" name="<?=$field->title()?>" value="0">
                                        <input type="radio" name="<?=$field->title()?>" <?=($src[$field->title()] == 1 ) ? 'checked' : '';?> value="1">
                                        <span class="switch"></span>
                                    </span>
                                </span>
    </div>
<?}elseif($field->showField('insert_type') == 'tumbler-value'){?>
    <div class="box flex-box flex-vertical-center">
        <div>
            <span class="toggle-item box">
                                    <span class="toggle-bg">
                                        <input type="radio" name="<?=$field->title()?>" value="0">
                                        <input type="radio" name="<?=$field->title()?>" <?=($src[$field->title()] == 1 ) ? 'checked' : '';?> value="1">
                                        <span class="switch"></span>
                                    </span>
            </span>
        </div>
        <div>
            <input type='number' name='<?=$field->title()?>_value' <?=$field->showField('require_type')?>  placeholder='<?=$field->description()?>' value='<?=($src[$field->title().'_value'])? $src[$field->title().'_value'] : ''; ?>'/>
        </div>
    </div>

<?}elseif($field->showField('insert_type') == 'rating'){?>
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
<?}elseif($field->showField('insert_type') == 'photos'){?>
    <div class="form-files files-field-<?=$field->title()?> ">
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
            <?}else{ ?>
                <div class='form-file'>
                    <i class="fa fa-file-image-o fa-5x" aria-hidden="true" ></i>
                </div>
            <?}?>
        </div>
        <input type="file" class="file-input"  name="<?=$field->title()?>[]" value=""  accept="image/*,image/jpeg"><br>

        <?if($post->showJsonField($field->title()) != NULL){ ?>
            <div class='photo_resort' data-field="<?=$field->title()?>">
                <i class="fas fa-save"></i>
            </div>
        <?} ?>
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
            $photodir = $_SERVER['DOCUMENT_ROOT']."/uploads/".$table_obj->showField('table_directory')."/".$src['id']."/";
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
                                    <!--+<?=$object->photoCount() - $i?>-->
                                </div>
                            <?}?>
                        </div>
                    </div>
                    <?$i++;}?>
                <?if($i > 15){break;}?>
            <?}?>
        </div>
    </div>
<?}elseif($field->showField('insert_type') == 'files'){?>
    <div class="form-files files-field-<?=$field->title()?> ">
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
            <?}else{ ?>
                <div class='form-file'>
                    <i class="fa fa-file-image-o fa-5x" aria-hidden="true" ></i>
                </div>
            <?}?>
        </div>
        <input type="file" class="file-input"  name="<?=$field->title()?>[]" value=""  accept="image/*,image/jpeg"><br>

        <?if($post->showJsonField($field->title()) != NULL){ ?>
            <div class='photo_resort' data-field="<?=$field->title()?>">
                <i class="fas fa-save"></i>
            </div>
        <?} ?>
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
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
        <select style="width: 80px;" class="<?= (trim($src[$field->title().'_value'])) ? 'field-checked' :'' ?>" <?=($field->getField('field_required') ? 'required' : '')?> name='<?=$field->title().'_value'?>'>
            <?
            if(trim($src[$field->title().'_value'])){
                $table_post = new Post($src[$field->title().'_value']);
                $table_post->getTable($field->getField('linked_table'));
                echo "<option value='".$table_post->postId()."'>".$table_post->title()."</option>";
            }else{
                echo "<option value=''>Выберите</option>";
            }
            $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table')." ");
            $sql->execute();
            while($sql_src = $sql->fetch(PDO::FETCH_LAZY)){?>
                <?if($src[$field->title().'_value'] != $sql_src->id ){?>
                    <option value='<?=$sql_src->id?>'><?=$sql_src->title?></option>;
                <?}?>
            <?}?>
        </select>
    </div>
</div>
<?
    if($_POST[$field->title()]){
        $value_item = $_POST[$field->title()];
    }else{
        $value_item = $src[$field->title()];
    }

    if($_POST[$field->title().'_value']){
        $value_item_value = $_POST[$field->title().'_value'];
    }else{
        $value_item_value = $src[$field->title().'_value'];
    }
    if(!$value_item_value){
        $value_item_value = '';
    }
?>
<div class="flex-box">
    <select style=" width: 120px !important; " class="<?= (trim($src[$field->title()])) ? 'field-checked' :'' ?>" <?=($field->getField('field_required') ? 'required' : '')?> name='<?=$field->title()?>'>
        <?
        if(trim($value_item)){
            $table_post = new Post($value_item);
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
        <option value="0">Не выбрано</option>
    </select>
    <div>
        -
    </div>
    <div class="flex-box" >
        <div style="border: 1px solid #E0E0DD;  background: #ffffff; ">
            <input style=" width: 43px !important; " class="filter-input" name="<?=$field->title()?>_value" value="<?=$value_item_value?>"  type="number" placeholder=" " />
        </div>
        <div class="ghost">
            <?=$field->getField('dimension_last')?>
        </div>
    </div>
</div>
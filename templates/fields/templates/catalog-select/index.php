<?if(!$arr_value){
    $arr_value = ['',''];
}?>
<div class="flex-box">
    <select style=" width: 120px !important; " class="<?= (trim($src[$field->title()])) ? 'field-checked' :'' ?>" <?=($field->getField('field_required') ? 'required' : '')?> name='<?=$field->title()?>[]'>
        <?
        if(trim($arr_value[0])){
            $table_post = new Post($arr_value[0]);
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
        <?/*<option value="0">Не выбрано</option>*/?>
    </select>
    <div>
        -
    </div>
    <div class="flex-box" >
        <div style="border: 1px solid #E0E0DD;  background: #ffffff; ">
            <input style=" width: 43px !important; " class="filter-input" name="<?=$field->title()?>[]" value="<?=$arr_value[1]?>"  type="number" placeholder=" " />
        </div>
        <div class="ghost">
            <?=$field->getField('dimension_last')?>
        </div>
    </div>
</div>

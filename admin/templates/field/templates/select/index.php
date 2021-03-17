<select  class="<?= (trim($src[$field->title()])) ? 'field-checked' :'' ?>" <?=($field->getField('field_required') ? 'required' : '')?> name='<?=$field->title()?>'>
    <?
    if(trim($src[$field->title()])){
        $table_post = new Post((int)$src[$field->title()]);
        $table_post->getTable($field->getField('linked_table'));
        echo "<option value='".$table_post->postId()."'>".$table_post->title()."</option>";
    }else{
        echo "<option value=''>Выберите</option>";
    }
    $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table')." ");
    $sql->execute();
    while($sql_src =$sql->fetch(PDO::FETCH_LAZY)){
        echo "<option value='".$sql_src->id."'>".$sql_src->title."</option>";
    }
    ?>
</select>
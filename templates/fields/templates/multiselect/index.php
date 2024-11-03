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
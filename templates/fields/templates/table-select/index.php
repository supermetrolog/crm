<select name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?> >
    <?
    if($src[$field->title()] != ''){
        echo "<option value='".$src[$field->title()]."'>".$src[$field->title()]."</option>";
    }
    $sql= $pdo->prepare("SHOW TABLES FROM". DB_NAME." ");
    $sql->execute();
    while($table = $sql->fetch()){?>
        <option value='<?=$table["Tables_in_$db"]?>'><?=$table["Tables_in_$db"]?></option>
    <?}?>
</select>
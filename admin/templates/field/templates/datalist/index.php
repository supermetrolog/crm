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
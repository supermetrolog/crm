<select name='linked_table'>
    <?$db = DB_NAME ?>
    <option value='<?=$src['linked_table']?>'><?=$src['linked_table']?> (Выбрано)</option>
    <?php
    $WHITE_LIST = array();
    $tables_sql= $pdo->prepare("SHOW TABLES FROM $db");
    $tables_sql->execute();
    $i = 0;
    while($table = $tables_sql->fetch()){?>
        <option value='<?=$table["Tables_in_$db"]?>'><?=$table["Tables_in_$db"]?></option>
        <?   $i++;
    } ?>
</select>
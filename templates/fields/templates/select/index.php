<?
if($field->getField('is_multifield')){
    $name = $field->title().'[]';
}else{
    $name = $field->title();

    if($_POST[$field->title()]){
        $value_item = $_POST[$field->title()];
    }elseif($src[$field->title()]){
        $value_item = $src[$field->title()];
    }else{
}

    /*
    if($field->getField('is_multifield')){
        $name = $field->title().'[]';
    }else{
        $name = $field->title();
        $value_item = $src[$field->title()];
    }
    */

}

if(is_array($test = json_decode($value_item,true))){
    if(!arrayIsNotEmpty($test)){
        $value_item = '';
    }
}

//ДЛЯ АКТИВНЫХ АГЕНТОВ
if($field->title() == 'agent_id'){
    $active = 'WHERE activity=1';
}else{
    $active = '';
}

if($_COOKIE['member_id'] == 141){
    //include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');
   //echo $value_item;

}

?>

<select style="max-width: 150px;" id="field-<?=$field->title()?>" class="<?= (trim($value_item)) ? 'field-checked' :'' ?>" <?=($field->getField('field_required') ? 'required' : '')?> name='<?=$name?>' <?=($field->getField('field_is_disabled')) ? 'disabled' : '' ?>>
    <?

    if(trim($value_item) != null && trim($value_item) != 'null'){

        $table_post = new Post($value_item);
        $table_post->getTable($field->getField('linked_table'));


        echo "<option value='".$table_post->postId()."'>".$table_post->title()."</option>";
    }else{
        echo "<option value=''>Выберите</option>";
    }
    if(!$field->getField('field_list_empty')){
        $sql = $pdo->prepare("SELECT * FROM ".$field->getField('linked_table')." $active ");
        $sql->execute();
        while($sql_src =$sql->fetch(PDO::FETCH_LAZY)){
            if($src[$field->title()] != $sql_src->id && $sql_src->title){
                echo "<option value='".$sql_src->id."'>".$sql_src->title."</option>";
            }
        }
    }
    echo "<option value=''>Выберите</option>";

    ?>
</select>
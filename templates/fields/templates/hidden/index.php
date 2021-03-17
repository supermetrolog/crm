<?
if($_POST[$field->title()]){
    $value_item = $_POST[$field->title()];
}else{
    //if(!$value_item  ){
        if(is_array($src[$field->title()]) ){
            if(count($src[$field->title()]) > 0){
                $value_item = $src[$field->title()];
            }
        }else{
            $value_item = $src[$field->title()];
        }
    //}
}

?>

<input id="field-<?=$field->title()?>" type='hidden'  name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?>  value='<?=($value_item) ? $value_item : ''; ?>'/>

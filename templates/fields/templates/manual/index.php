<?
//$value_item = '';
//include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';

if($_COOKIE['member_id'] == 141 || $_COOKIE['member_id'] == 150){
    //echo $table;
    //echo $post->postId();


    if($table == 'c_industry_blocks'){
        if($field->title() == 'floor') {
            if ($src['id']) {
                $help_offer = new Offer($post->getField('offer_id'));
                $help_obj = new Building($help_offer->getField('object_id'));
            } else {
                $help_obj = new Building($_POST['object_id']);
            }
            $help_field_all = 'floors';
            $help_res = $help_obj->getField($help_field_all);


        }elseif($field->title() == 'power'){
            if ($src['id']) {
                $help_offer = new Offer($post->getField('offer_id'));
                $help_obj = new Building($help_offer->getField('object_id'));
                $help_sum = $help_offer->getOfferBlocksMaxSumValueAllExcept($src['id'],$field->title());
            } else {
                $help_offer = new Offer($_POST['offer_id']);
                $help_obj = new Building($help_offer->getField('object_id'));
                $help_sum = $help_offer->getOfferBlocksMaxSumValue($field->title());
            }
            $help_all = $help_obj->getField($field->title());



            $help_res = $help_all - $help_sum ;
        }else{

        }
        //if(!$help_res){
        //    $help_res = 0;
        //}
    }

}


if($table == 'c_industry_floors') {
    $object = new Building($_POST['object_id']);
    if ($obj_val = $object->getField($field->title())) {
        $obj_val = 'из ' . $obj_val;
    } else {
        $obj_val = '';
    }
}


if($_POST[$field->title()]) {
    $value_item = $_POST[$field->title()];
}elseif($value_item && $field->getField('is_multifield')){

}else{
    if($src[$field->title()] && $src[$field->title()] != NULL){
        $value_item = $src[$field->title()];
    }else{
        $value_item = '';
    }
}

?>

<?if($before = $field->getField('field_before') ){
    echo $before; 
}?>
<?if($field->getField('field_input_type') == 'address'){?>
    <input id="field-<?=$field->title()?>"  type="text"   name='<?=$field->title()?>' <?=($field->getField('field_required') ? 'required' : '')?>  placeholder=' ' value='<?=$value_item ?? ''; ?>'/>
<?}else{?>
    <input  step="0.1"   <?/* max="<?=$help_res?>" */?>  id="field-<?=$field->title()?>"  type="<?=$field->getField('field_input_type')?>"  name='<?=$field->title()?><?=($field->getField('is_multifield')) ? '[]' : ''?>'  <?if($field->getField('field_pattern')) {?> pattern="<?=$field->getField('field_pattern')?>" <?}?>   placeholder=' '  value='<?=$value_item ?? ''?>'  class="<?=($field->getField('singleword'))? 'singleword' : '';?> "   <?=($field->getField('field_is_disabled'))? 'disabled="disabled"' : '';?>   <?=($field->getField('field_required') ? 'required' : '')?>  />
    <span class="box-wide ghost">
        <?=$obj_val?>
    </span>

<?}?>

<?
$value_item = '';
?>

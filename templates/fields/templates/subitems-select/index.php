<div class="flex-box flex-wrap">
    <?
    if($_POST['offer_id']){
        $offer_id = $_POST['offer_id'];
    }else{
        $offer_id = $src['offer_id'];
    }
    $offer = new Offer($offer_id);
    $building = new Building($offer->getField('object_id'));
    $items = $building->getJsonField(str_replace('_block','', $field->title()));
    foreach($items as $item){?>
        <?$purpose = new Post($item)?>
        <?$purpose->getTable($field->getField('linked_table'))?>
            <div class="toggle-checkbox" title="<?=$purpose->getField('title')?>">
                <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-<?=$item?>" value="<?=$item?>" name="<?=trim($field->title())?>[]" <?=(in_array($item,json_decode($src[$field->title()]))) ? 'checked' : '' ;?> type="checkbox"/>
                <label for="<?=trim($field->title())?>-<?=$item?>" class="full-width block-field-select" >
                    <?=$purpose->getField('icon')?>
                </label>
            </div>
        <?}?>
</div>
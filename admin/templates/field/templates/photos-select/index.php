<div class="flex-box flex-wrap">
    <?
    $offer = new Offer($src['offer_id']);
    $building = new Building($offer->getField('object_id'));
    $photos = $building->getJsonField('photo');
    foreach($photos as $photo){?>
        <div class="toggle-checkbox full-width" style="margin: 10px;" title="<?=$photo?>">
            <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-<?=$photo?>" value="<?=$photo?>" name="<?=trim($field->title())?>[]" <?=(in_array($photo,json_decode($src[$field->title()]))) ? 'checked' : '' ;?> type="checkbox"/>
            <label  for="<?=trim($field->title())?>-<?=$photo?>" class="full-width " >
                <div class="background-fix" style="width: 100%; height: 200px; background-image: url( '<?=$photo?>') ">

                </div>
            </label>
        </div>
    <?}?>
</div>
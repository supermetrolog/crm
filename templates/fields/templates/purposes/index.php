<div class="flex-box flex-wrap">
    <?foreach($field->getFieldVariants() as $field_item){
        ?>
        <?if(isset($_POST['is_land'])){
            $isLand = $_POST['is_land'];
        }else{
            $isLand = $post->getField('is_land');
        }?>

        <?if($isLand == 1){?>
            <?if(in_array(2,json_decode($field_item['type']))){?>
                <div class="toggle-checkbox" style="margin: 3px;" title="<?=$field_item['title']?>">
                    <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],json_decode($src[$field->title()]))) ? 'checked' : '' ;?> type="checkbox"/>
                    <label for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                        <span class="box-wide"><?=$field_item['icon']?></span> <?=$field_item['title']?>
                    </label>
                </div>
            <?}?>
        <?}else{?>
            <?if(in_array(1,json_decode($field_item['type']))){?>
                <div class="toggle-checkbox" style="margin: 3px;" title="<?=$field_item['title']?>">
                    <input <?=$field->getField('require_type')?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],json_decode($src[$field->title()]))) ? 'checked' : '' ;?> type="checkbox"/>
                    <label for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                        <span class="box-wide"><?=$field_item['icon']?></span> <?=$field_item['title']?>
                    </label>
                </div>
            <?}?>
        <?}?>
    <?}?>
</div>
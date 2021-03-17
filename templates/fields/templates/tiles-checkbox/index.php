<div class="flex-box flex-wrap">
    <input type="hidden" name="<?=trim($field->title())?>" value="0" />
    <?if($table == 'c_industry_parts'){?>
        <?
        $floor = new Floor($_POST['floor_id'] ?? $src['floor_id']);
        $floor_field_arr  = json_decode($floor->getField($field->title()),true);
        ?>
        <?if($src['id']){?>
            <?if($field->getField('field_required')){?>
                <? $required = 'required'?>
            <?}else{?>
                <? $required = ''?>
            <?}?>
            <?if($src[$field->title()]){?>
                <? $required = ''?>
            <?}?>
            <?if($floor->getField($field->title())){?>
                <? $required = ''?>
            <?}?>
            <?foreach($field->getFieldVariants() as $field_item){
                ?>
                <div class="toggle-checkbox" style="margin: 3px; position: relative;" title="<?=$field_item['title']?>">
                    <input <?=$required?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],json_decode($src[$field->title()]))) ? 'checked' : '' ;?> type="checkbox"/>
                    <label for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                        <?if($field_item['title_short']){?>
                            <?=$field_item['title_short']?>
                        <?}elseif($field_item['icon']){?>
                            <?=$field_item['icon']?>
                        <?}else{?>
                            <?=$field_item['title']?>
                        <?}?>
                    </label>
                    <?if( $floor->hasField($field->title()) && !in_array($field_item['id'],$floor_field_arr) ){?>
                        <div title="Невозможно выбрать пока в этаже не проставлено" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,.5)">

                        </div>
                    <?}?>
                </div>
            <?}?>
        <?}else{?>
            <?if($field->getField('field_required')){?>
                <? $required = 'required'?>
            <?}else{?>
                <? $required = ''?>
            <?}?>
            <?if($src[$field->title()]){?>
                <? $required = ''?>
            <?}?>
            <?if($floor->getField($field->title())){?>
                <? $required = ''?>
            <?}?>
            <?foreach($field->getFieldVariants() as $field_item){
                ?>
                <div class="toggle-checkbox" style="margin: 3px; position: relative;" title="<?=$field_item['title']?>">
                    <input <?=$required?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],$floor_field_arr)) ? 'checked' : '' ;?> type="checkbox"/>
                    <label for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                        <?if($field_item['title_short']){?>
                            <?=$field_item['title_short']?>
                        <?}elseif($field_item['icon']){?>
                            <?=$field_item['icon']?>
                        <?}else{?>
                            <?=$field_item['title']?>
                        <?}?>
                    </label>
                    <?if($floor->hasField($field->title()) && !in_array($field_item['id'],$floor_field_arr) ){?>
                        <div title="Невозможно выбрать пока в этаже не проставлено" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255,255,255,.5)">

                        </div>
                    <?}?>
                </div>
            <?}?>
        <?}?>
    <?}else{?>
        <?if($field->title() == 'floors_building'){?>
            <?
            $isLand = $_POST['is_land'] ?? $src['is_land'];

            $variants = $field->getFieldVariants();

            $variants_filtered = [];
            if($isLand){
                $variants_filtered = [];
                foreach ($variants as $item){
                    if($item['id'] == 16){
                        $variants_filtered[] = $item;
                    }
                }
            }else{
                $variants_filtered = [];
                foreach ($variants as $item){
                    if($item['id'] !=16){
                        $variants_filtered[] = $item;
                    }
                }
                //unset($variants[array_search('16', $variants)]);
            }
            ?>
            <?foreach($variants_filtered as $field_item){
                ?>
                <div class="toggle-checkbox <?if($field->postId() == 505){?>full-width<?}?>" style="margin: 3px;" title="<?=$field_item['title']?>">
                    <input <?if($field->getField('field_required') && !$src[$field->title()]){?> required <?}?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],json_decode($src[$field->title()])) || $field_item['id'] == '16') ? 'checked' : '' ;?> type="checkbox"/>
                    <label class="<?if($field->postId() == 505){?>full-width<?}?>" for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                        <?if($field_item['title_short']){?>
                            <?=$field_item['title_short']?>
                        <?}elseif($field_item['icon']){?>
                            <?=$field_item['icon']?>
                        <?}else{?>
                            <?=$field_item['title']?>
                        <?}?>
                    </label>
                </div>
            <?}?>
        <?}else{?>
            <?foreach($field->getFieldVariants() as $field_item){
                ?>
                <div class="toggle-checkbox <?if($field->postId() == 505){?>full-width<?}?>" style="margin: 3px;" title="<?=$field_item['title']?>">
                    <input <?if($field->getField('field_required') && !$src[$field->title()]){?> required <?}?> id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],json_decode($src[$field->title()]))) ? 'checked' : '' ;?> type="checkbox"/>
                    <label class="<?if($field->postId() == 505){?>full-width<?}?>" for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                        <?if($field_item['title_short']){?>
                            <?=$field_item['title_short']?>
                        <?}elseif($field_item['icon']){?>
                            <?=$field_item['icon']?>
                        <?}else{?>
                            <?=$field_item['title']?>
                        <?}?>

                    </label>
                </div>
            <?}?>
        <?}?>
    <?}?>

</div>
<div class="flex-box flex-wrap flex-vertical-top">
    <? $purposes = json_decode($src['purposes']);?>
    <? ($_POST['is_land'] == 1 || $src['is_land'] == 1) ? $isLand = 1 : $isLand = 0 ; ?>
    <?foreach($field->getFieldVariants() as $field_item){?>
        <?if($field_item['is_land'] == $isLand  || $table_id == 18){?>
            <div class="object-type-block full-width">
                <div class="toggle-checkbox" style="margin: 3px; width: 30px; " title="<?=$field_item['title']?>">
                    <input class="object-type-field" id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],json_decode($src[$field->title()])) ) ? 'checked' : '' ;?> type="checkbox"/>
                    <label style="border: 3px dashed black;" for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                        <?=$field_item['title']?>
                    </label>
                </div>
                <div class="purpopes <?if(!in_array($field_item['id'],json_decode($src[$field->title()]))){?> hidden <?}?>">
                    <div class=" flex-box flex-wrap" >
                        <?
                        $type = $field_item['id'];
                        $sql = $pdo->prepare("SELECT * FROM l_purposes WHERE type=$type");
                        $sql->execute();
                        ?>
                        <?while($purpose = $sql->fetch(PDO::FETCH_LAZY)){?>
                            <div class="toggle-checkbox" style="margin: 3px;" title="<?=$purpose->title?>">
                                <input  id="purposes-<?=$purpose->id?>" value="<?=$purpose->id?>" name="purposes[]" <?=(in_array($purpose->id,json_decode($src['purposes']))) ? 'checked' : '' ;?> type="checkbox"/>
                                <label for="purposes-<?=$purpose->id?>">
                                    <?if($purpose->title_short){?>
                                        <?=$purpose->title_short?>
                                    <?}elseif($purpose->icon){?>
                                        <?=$purpose->icon?>
                                    <?}else{?>
                                        <?=$purpose->title?>
                                    <?}?>
                                </label>
                            </div>
                        <?}?>
                    </div>

                </div>
            </div>
        <?}?>


    <?}?>
</div>







<?php


/*

<div class="flex-box flex-wrap flex-vertical-top">
    <? $purposes = json_decode($src['purposes']);?>
    <? ($_POST['is_land'] == 1 || $src['is_land'] == 1) ? $isLand = 1 : $isLand = 0 ; ?>
    <?foreach($field->getFieldVariants() as $field_item){?>
        <?if($field_item['is_land'] == $isLand  || $table_id == 18){?>
            <div class="object-type-block">
                <div class="toggle-checkbox" style="margin: 3px;" title="<?=$field_item['title']?>">
                    <input class="object-type-field" id="<?=trim($field->title())?>-<?=$field_item['id']?>" value="<?=$field_item['id']?>" name="<?=trim($field->title())?>[]" <?=(in_array($field_item['id'],json_decode($src[$field->title()])) || $isLand == 1) ? 'checked' : '' ;?> type="checkbox"/>
                    <label for="<?=trim($field->title())?>-<?=$field_item['id']?>">
                        <?if($field_item['title_short']){?>
                            <?=$field_item['title_short']?>
                        <?}elseif($field_item['icon']){?>
                            <?=$field_item['icon']?>
                        <?}else{?>
                            <?=$field_item['title']?>
                        <?}?>
                    </label>
                </div>
                <div class="custom-select-body dont-hide" style=" <?=(in_array($field_item['id'],json_decode($src[$field->title()])) || $isLand == 1) ? 'display: block;' : '' ;?> position: relative;">
                    <ul class="custom-select-list">
                        <?
                        $type = $field_item['id'];
                        $sql = $pdo->prepare("SELECT * FROM l_purposes WHERE type=$type");
                        $sql->execute();
                        ?>
                        <?while($purpose = $sql->fetch(PDO::FETCH_LAZY)){?>
                            <li>
                                <div>
                                    <input  id="<?='purposes-'.$purpose->id?>" <?= (in_array($purpose->id, $purposes )? 'checked="checked"' : '')?> value="<?=$purpose->id?>" name="purposes[]" type="checkbox" />
                                    <label title=""  style="padding: 5px 10px; box-sizing: border-box;"  class="flex-box pointer" for="<?='purposes-'.$purpose->id?>">
                                        <div>
                                            <?=$purpose->title?>
                                        </div>
                                        <div class="to-end">
                                            <i class="fas fa-check"></i>
                                        </div>
                                    </label>
                                </div>
                            </li>
                        <?}?>

                    </ul>
                </div>
            </div>
        <?}?>


    <?}?>
</div>
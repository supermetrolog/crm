<?//include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php' ?>
<div class="flex-box flex-wrap">
    <?
    if($table_id == 34){ //если это этажи
        if($object_id = $_POST['object_id']){
            $building = new Building($object_id);
        }else{
            $floor_id = $src['id'];
            $floor_obj = new Floor($floor_id);
            $building = new Building($floor_obj->getField('object_id'));
        }
        $files = $building->getJsonField(str_replace('_block','', $field->title()));
    }elseif($table_id == 35){         //если куски на этажах
        if($floor_id = $_POST['floor_id']){
            $floor_obj = new Floor($floor_id);
        }else{
            $part_id = $src['id'];
            $part = new Part($part_id);
            $floor_obj = new Floor($part->getField('floor_id'));
        }
        $files = $floor_obj->getJsonField(str_replace('','', $field->title()));
    }else{             //если это  ТП напрямую из обьекта
        if($_POST['offer_id']){
            $offer_id = $_POST['offer_id'];
        }else{
            $offer_id = $src['offer_id'];
        }
        $offer = new Offer($offer_id);
        $building = new Building($offer->getField('object_id'));
        $files = $building->getJsonField(str_replace('_block','', $field->title()));
    }


    $i = 0;
    foreach ($files as $file) {?>
        <?$ext = getFileExtension($file)?>
        <?if(in_array(strtolower($ext),['.jpg','.jpeg','.png','.gif'])){?>
            <div class="toggle-checkbox" style="width: 20%; margin: 10px;" title="<?=$file?>">
                <input <? if(in_array($table_id,[35,34]) && count(json_decode($src[$field->title()])) < 1 ){ ?> required  <? }?><? if ($i === 0) {?>   <? } ?>   id="<?=trim($field->title())?>-<?=$file?>" value="<?=$file?>" name="<?=trim($field->title())?>[]" <?=(in_array($file,json_decode($src[$field->title()])) || ($table_id == 34 && $field->postId() == 316 && $src['floor_num'] == '1f' )) ? 'checked' : '' ;?> type="checkbox"/>
                <label  for="<?=trim($field->title())?>-<?=$file?>" class="full-width block-field-select" >
                    <div class="background-fix" style="width: 100%; height: 200px; background-image: url( '<?=$file?>') ">

                    </div>
                </label>
            </div>
        <?}else{?>
            <div class="toggle-checkbox" style="width: 20%; margin: 10px;" title="<?=$file?>">
                <input <? if ($i === 0) {?>   <? } ?>    id="<?=trim($field->title())?>-<?=$file?>" value="<?=$file?>" name="<?=trim($field->title())?>[]" <?=(in_array($file,json_decode($src[$field->title()])) ) ? 'checked' : '' ;?> type="checkbox"/>
                <label  for="<?=trim($field->title())?>-<?=$file?>" class="full-width block-field-select" >
                    <div class="background-fix" style="width: 100%; height: 200px; background-image: url( '<?=$file?>') ">
                        <div class='files-grid-unit' data-src="<?=$file?>" >
                            <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                <div style="font-size: 60px;" title="<?=getFilePureName($file)?> <?=$ext?>">
                                    <?=getFileIcon($file)?>
                                </div>
                                <div title="<?=getFilePureName($file)?>" class="box-small text_center full-width to-end-vertical grey-background" >
                                    <a href="<?=$file?>" target="_blank" class="text_center">
                                        <div class="flex-box flex-center">
                                            <div class="box-wide" style="font-size: 20px;">
                                                <?=getFileIcon($file)?>
                                            </div>
                                            <div>
                                                <?=getFileNameShort($file)?> <?=$ext?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="file-delete icon-round"  >
                                <i class='fa fa-times' aria-hidden='true'></i>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        <?}?>
        <? $i++ ?>
    <?}?>
</div>

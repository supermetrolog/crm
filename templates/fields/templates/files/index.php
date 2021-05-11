 <div class="form-files files-field-<?=$field->title()?> files-list   ">
        <div class="draggable flex-box flex-wrap files-grid" <?if($post->id){?> data-id="<?=$post->postId()?>" data-table="<?=$post->setTableId()?>" data-field="<?=$field->title()?>" <?}?> >
            <?if($post->id){?>
                <? if($post->showJsonField($field->title()) != NULL){?>
                    <?foreach($post->showJsonField($field->title()) as $file_unit){?>
                        <div class='files-grid-unit' data-src="<?=$file_unit?>" >
                            <?$ext = getFileExtension($file_unit)?>
                            <div class="text_center full-height flex-box flex-box-vertical grey-border">
                                <div class="box">

                                </div>
                                <div style="font-size: 60px;" title="<?=getFilePureName($file_unit)?> <?=$ext?>">
                                    <?=getFileIcon($file_unit)?>
                                </div>
                                <div title="<?=getFilePureName($file_unit)?>" class="box-small text_center full-width to-end-vertical grey-background" >
                                    <a href="<?=$file_unit?>" target="_blank" class="text_center">
                                        <div class="flex-box flex-center">
                                            <div class="box-wide" style="font-size: 20px;">
                                                <?=getFileIcon($file_unit)?>
                                            </div>
                                            <div>
                                                <?=getFileNameShort($file_unit)?> <?=$ext?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="file-delete icon-round"  >
                                <i class='fa fa-times' aria-hidden='true'></i>
                            </div>
                        </div>
                    <?}?>
                <?}?>
            <?}?>
        </div>
        <div class="box">

        </div>
        <label class="box-vertical label-custom"  >
            <div>
                загрузить  <?=$field->description()?>
            </div>
            <input multiple type="file" class="file-input-multiple"  name="<?=$field->title()?>[]" value=""  accept="/*">
        </label>




     <!---
            <div class="box-vertical label-custom">
            <input multiple id="form_element_<?=$field->title()?>" type="file" class="file-input-multiple"  name="<?=$field->title()?>[]" value=""  accept="/*">
            <label for="form_element_<?=$field->title()?>">загрузить <?=$field->description()?></label>
        </div>

     -->

</div>
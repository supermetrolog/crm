<div class="form-files files-field-<?=$field->title()?> files-single ">
    <?if($post->id > 0){?>
        <div class="draggable">
            <? if(($photo = $post->showField($field->title())) != NULL){?>
                    <div class='form-file'>
                        <img src='<?=$photo?>'/>
                        <div class="file-delete" data-field="<?=$field->title()?>">
                            <i class='fa fa-times' aria-hidden='true'></i>
                        </div>
                    </div>
            <?}?>
        </div>
    <?}?>
    <div>
        <input id="form_element_<?=$field->title()?>" type="file" class="file-input"  name="<?=$field->title()?>" value=""  accept="image/*,image/jpeg">
        <label for="form_element_<?=$field->title()?>">загрузить <?=$field->description()?></label>
    </div>
</div>
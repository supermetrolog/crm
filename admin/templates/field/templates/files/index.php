<div class="form-files files-field-<?=$field->title()?> ">
    <?if($post->id > 0){?>
        <div class="draggable">
            <? if($post->showJsonField($field->title()) != NULL){?>
                <?foreach($post->showJsonField($field->title()) as $file_unit){?>
                    <div class='form-file'>
                        <img src='<?=$file_unit?>'/>
                        <div class="file-delete" data-field="<?=$field->title()?>">
                            <i class='fa fa-times' aria-hidden='true'></i>
                        </div>
                    </div>
                <?}?>
            <?}?>
        </div>
        <div>
            <input id="form_element_<?=$field->title()?>" type="file" class="file-input"  name="<?=$field->title()?>[]" value=""  accept="image/*,image/jpeg">
            <label for="form_element_<?=$field->title()?>">загрузить<br> <?=$field->description()?></label>
        </div>
        <?if($post->showJsonField($field->title()) != NULL){ ?>
            <div class='photo_resort' data-field="<?=$field->title()?>">
                <i class="fas fa-save"></i>
            </div>
        <?} ?>
    <?}?>

    <script>
        $(document).ready( function() {
            $('body').on('input', '.files-field-<?=$field->title()?>  input:last', function () {
                alert('последний');
                $(this).closest('.form-files').append('<input type="file" class="file-input"   name="<?=$field->title()?>[]" multiple="" accept="image/*,image/jpeg">')
            });
        });
    </script>
</div>
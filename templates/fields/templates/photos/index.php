<div class="form-files files-field-<?=$field->title()?> files-list   ">
        <div class="draggable flex-box flex-wrap <?=($field->getField('photo_template_grid'))? 'files-grid' : 'files-column' ?>" <?if($post->id){?> data-id="<?=$post->postId()?>" data-table-id="<?=$post->setTableId()?>" data-field="<?=$field->title()?>" <?}?> >
            <?if($post->id){?>
                <? if($post->showJsonField($field->title()) != NULL){?>
                    <?foreach($post->getJsonField($field->title()) as $key=>$value){?>
                        <?$thumbs = $post->getThumbs($field->title())?>
                        <div class='files-grid-unit'  data-src="<?=$value?>" >
                            <div class="background-fix photo-container" style="background: url('<?=PROJECT_URL.'/system/controllers/photos/thumb_all.php/?width=300&photo='.PROJECT_URL.$value ?>')">
                                <div class="file-show">
                                    <a href="<?=$value?>" target="_blank" class="icon-round">
                                        <i class="far fa-file"></i>
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
        <label class="label-custom pointer" >
            <div>
                Загрузить
            </div>
            <input multiple id="form_element_<?=$field->title()?>" type="file" class="file-input-multiple" <?if($field->gf('field_accept')){?> accept="<?=$field->gf('field_accept')?>"  <?}?> name="<?=$field->title()?>[]" value=""  >
        </label>
</div>
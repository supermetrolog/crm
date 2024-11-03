<?php


if($post){


    //var_dump($post);
    //$table = new Table( $post->setTableId());
    //var_dump($table);

    $id = $post->postId();

    if($post->hasField('object_type')){
        $table_name = 'objects';
    }else{
        $table_name = 'companies';
    }



    $files = array_diff( scandir(PROJECT_ROOT."/uploads/files_old/$table_name/$id/"), ['..', '.']); //иначе scandir() дает точки
    $files_list = [];

    //echo 'лот номер'. "<b>$id</b>";
    //echo 'его фотки далее<br>';
    foreach ($files as $file) {
        $files_list[] = PROJECT_ROOT."/uploads/files_old/$table_name/$id/".$file;

    }
    ?>

    <div class="form-files files-field-<?=$field->title()?> files-list   ">
        <div class="draggable flex-box flex-wrap files-grid" <?if($post->postId()){?> data-id="<?=$post->postId()?>" data-table="<?=$post->setTableId()?>" data-field="<?=$field->title()?>" <?}?> >
            <?if($post->postId()){?>
                <? if($files != NULL){?>
                    <?foreach($files_list as $file_unit){?>
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
                                                <a href="<?= "/uploads/files_old/$table_name/$id/".array_pop(explode('/',$file_unit))?>" target="_blank">
                                                    <?=array_pop(explode('/',$file_unit))?> <?//=$ext?>
                                                </a>
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
    </div>

<?}?>
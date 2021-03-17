<div class="form-files files-field-<?=$field->title()?> files-list">
    <div class="draggable">
        <?if($post->getJsonField($field->title()) != NULL){?>
            <?foreach($post->getJsonField($field->title()) as $file_unit){?>
                <div class='form-file'>
                    <img src='<?=$file_unit?>'/>
                    <div class="file-delete" data-field="<?=$field->title()?>">
                        <i class='fa fa-times' aria-hidden='true'></i>
                    </div>
                </div>
            <?}?>
        <?}else{?>
            <div class='form-file'>
                <i class="fa fa-file-image-o fa-5x" aria-hidden="true" ></i>
            </div>
        <?}?>
    </div>
    <input type="file" class="file-input-multiple"  name="<?=$field->title()?>[]" value=""  accept="image/*,image/jpeg"><br>

    <?if($post->getJsonField($field->title()) != NULL){?>
        <div class='photo_resort' data-field="<?=$field->title()?>">
            <i class="fas fa-save"></i>
        </div>
    <?}?>
    <script>
        $(document).ready( function() {
            $('body').on('input', '.files-field-<?=$field->title()?>  input:last', function () {
                //alert('последний');
                //$(this).closest('.form-files').append('<input type="file" class="file-input"   name="<?=$field->title()?>[]" multiple="" accept="image/*,image/jpeg">')
            });
        });
    </script>
    <div class="card-photos-grid draggable flex-box flex-wrap">
        <? $i = 1;

        $table_obj = new Table(0);
        $table_obj->getTableByName($_GET['table']);
        $photodir = $_SERVER['DOCUMENT_ROOT']."/uploads/".$table_obj->showField('table_directory')."/".$src['id']."/";
        $photos = scandir($photodir);
        //echo $photodir;
        //var_dump($photos);
        //echo $_SERVER['DOCUMENT_ROOT']."data/images/c_industry/$object_id/";
        //var_dump($photos);
        foreach($photos as $thumb){
            //foreach($object->thumbs() as $thumb){
            $thumb = trim($thumb,'.');
            if(stristr($thumb, 'del') === FALSE &&  $thumb != NULL){?>
                <div class="flex-box">
                    <div class="flex-box flex-around background-fix" style="background-image: url(<?=PROJECT_URL.'/'."uploads/objects/".$src['id']."/".$thumb?>) " >
                        <?if($i > 14){?>
                            <div class="isBold" style="font-size: 30px; color: white; cursor: pointer; text-shadow: 1px 1px 2px black, 0 0 1em #000000;  ">
                                +<?=(count($photos) - $i)?>
                                <!--+<?=$object->photoCount() - $i?>-->
                            </div>
                        <?}?>
                    </div>
                </div>
                <?$i++;}?>
            <?if($i > 15){break;}?>
        <?}?>
    </div>
</div>
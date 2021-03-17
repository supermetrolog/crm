<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 05.06.2018
 * Time: 12:01
 */
?>
<div class="edit-form ">
    <form enctype="multipart/form-data" action="<?=PROJECT_URL?>//modules/user_fields_visibility/index.php" method="POST" class="flex-box">
        <input type="hidden" name="member_id" value="<?=$logedUser->member_id()?>" />
        <div class="edit-user-fields text_left">
            <div>
                <?php
                $user_perm_sql = $pdo->prepare("SELECT * FROM user_show_fields_permissions WHERE member_id=:member_id");
                $user_perm_sql->bindParam(':member_id',$logedUser->member_id());
                $user_perm_sql->execute();
                $user_perm_line = $user_perm_sql->fetch(PDO::FETCH_LAZY);


                $sql = $pdo->prepare("SELECT * FROM user_show_fields WHERE activity='1'");
                $sql->execute();
                while($field = $sql->fetch(PDO::FETCH_LAZY)){?>
                    <div class="flex-box flex-between flex-vertical-center">
                        <div class="flex-box text_left">
                        <span>
                            <?=$field->description?>
                            <?=($field->required)? "*" : '' ;  ?>
                        </span>
                        </div>
                        <div class="right">
                            <select name="see_<?=$field->title?>" <?=($field->required)? 'required' : '' ;  ?> >
                                <?php
                                if($user_perm_sql->rowCount() > 0){
                                    $field_name = new Post($user_perm_line['see_'.$field->title]);
                                    $field_name->getTable('record_visibility');?>
                                    <option value="<?=$user_perm_line['see_'.$field->title]?>"><?=$field_name->title()?></option>
                                <?}
                                $canSeeGroup = new Post(0);
                                $canSeeGroup->getTable('record_visibility');
                                foreach ($canSeeGroup->getAllUnits() as $canSeeGroup){
                                    if($canSeeGroup['id'] != $user_perm_line['see_'.$field->title]){?>
                                    <option value="<?=$canSeeGroup['id']?>"><?=$canSeeGroup['title']?></option>
                                    <?}
                                }?>
                            </select>
                        </div>
                    </div>
                <?}?>
            </div>
            <div class="box">
            </div>
            <div>
                <button class="btn-arrow btn-blue">
                    Сохранить
                </button>
            </div>
            <div class="box">

            </div>
            <div class="underlined">
                <a href="">
                    Пользовательское соглашение
                </a>
            </div>
        </div>
        <div class="edit-user-avatar box">
            <div class='post_preview_upload box'>
                <output id="list_sec">
                <span>
                    <? if($logedUser->photo()){echo "<img class='thumb_tim_preload_sec' src='".$logedUser->avatar()."'/>";}else{ echo "<i class='fa fa-file-image-o fa-5x' aria-hidden='true'></i>" ;} ?>
                </span>
                </output><br>
                <input type="file" id="file" name="file" class="avatar-input"    accept="image/*,image/jpeg"><br>
                <label for="file" class='file_select_label'><i class="fa fa-plus-circle" aria-hidden="true"></i> Изменить фото</label>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    function handleFileSelect(evt) {
        var files = evt.target.files; // FileList object

        document.getElementById('list_sec').innerHTML = '';
        // Loop through the FileList and render image files as thumbnails.
        for (var i = 0, f; f = files[i]; i++) {

            // Only process image files.
            if (!f.type.match('image.*')) {
                continue;
            }

            var reader = new FileReader();

            // Closure to capture the file information.
            reader.onload = (function(theFile) {
                return function(e) {
                    // Render thumbnail.
                    var span = document.createElement('span');
                    span.innerHTML = ['<img class="thumb_tim_preload_sec" src="', e.target.result,
                        '" title="', theFile.name, '"/>'].join('');
                    document.getElementById('list_sec').insertBefore(span, null);
                };
            })(f);

            // Read in the image file as a data URL.
            reader.readAsDataURL(f);
        }
    }

    document.getElementById('file').addEventListener('change', handleFileSelect, false);
</script>

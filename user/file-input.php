<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 08.06.2018
 * Time: 10:40
 */
?>

<div class="file_input flex-box">
    <input id="record_file_<?=$_GET['input_num']?>" class="record_file" type="file"  name="files[]"/>
    <input id="file_name" class="file_name" type="text" placeholder="Файл не выбран"  disabled/>
    <label class="btn-blue record_file_label" for="record_file_<?=$_GET['input_num']?>"><span><i class="far fa-save"></i></span></label>
    <div class="delete_field box">
        <i class="fas fa-times"></i>
    </div>
    <br>
</div>


<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/global_pass.php';
if(isset($_POST['complex_id'])){
    $complex = new Complex((int)$_POST['complex_id']);
    $complex->updateField('mixer_parts','');
}




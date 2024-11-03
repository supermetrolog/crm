<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$logedUser = new Member($_COOKIE['member_id']);

$logedUser->updateField('favourites','');
$logedUser->updateField('presentations','');

header('Location: '. $_SERVER['HTTP_REFERER']);
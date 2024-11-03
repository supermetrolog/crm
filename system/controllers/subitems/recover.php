<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$block = new Subitem((int)$_GET['id']);

$block->updateField('deleted',0);

header('Location: ' . $_SERVER['HTTP_REFERER']);
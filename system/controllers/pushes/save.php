<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$client = new CloudPush();

$client->createLine(['member_id','token'],[$_POST['member_id'],$_POST['token']]);
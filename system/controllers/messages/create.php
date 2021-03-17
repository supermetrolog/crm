<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 13.06.2018
 * Time: 15:50
 */

require_once ($_SERVER['DOCUMENT_ROOT'].'global_pass.php');

$message = new Message(0);
$message->create($_GET['description'], $_GET['room_id']);
echo 111;

header("Location: ".$_SERVER['HTTP_REFERER']);


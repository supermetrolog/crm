<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 10.12.2018
 * Time: 16:38
 */
include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
(new Reminder())->sendReminds();
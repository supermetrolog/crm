<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 26.11.2018
 * Time: 16:47
 */
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
*/

require_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

$url = 'https://eu27.chat-api.com/instance17089/';
$token = 'tw3x2kcw4911icn1';

$artur = '+79672772550';
$tim = '+79672772550';



$whatsapp = new \Bitkit\Social\Whatsapp($url,$token);

$whatsapp->sendMessage($tim,'тест рассылка из бызы ');








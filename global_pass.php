<?php


//Корень проекта там где лежит  global_pass.php
define('PROJECT_ROOT', __DIR__);

//подключаем отображение ошибок
//include_once(PROJECT_ROOT.'/errors.php');

//Формируем URL
$isHttps = !empty($_SERVER['HTTPS']) && 'off' !== strtolower($_SERVER['HTTPS']);
($isHttps) ? $protocol = 'https' : $protocol = 'http';
$parts = explode($_SERVER['HTTP_HOST'],__DIR__);
$folder = array_pop($parts);
define('PROJECT_URL',$protocol.'://'.$_SERVER['HTTP_HOST'].$folder);


define("UPLOAD_DIR",'/uploads/');


//Записываем пассы в константы
define("DB_HOST", 'localhost');
define("DB_NAME", 'crm');
define("DB_USER", 'root');
define("DB_PASSWORD", 'root');

/*
//Записываем пассы к SMTP в константы
define("SMTP_HOST", 'ssl://email.realtor.ru');
define("SMTP_PORT", 25);
define("SMTP_USER", 'sklad@realtor.ru');
define("SMTP_PASSWORD", 'Ci5Za6To7');
*/


define("SMTP_HOST", 'ssl://smtp.yandex.ru');
define("SMTP_PORT", 465);
define("SMTP_USER", 'sonicspeedsss@yandex.ru');
define("SMTP_PASSWORD", '20091993dec');


/*
define("SMTP_HOST", 'ssl://smtp.mail.ru');
define("SMTP_PORT", 465);
define("SMTP_USER", 'sonicspeedsss@mail.ru');
define("SMTP_PASSWORD", '20091993decSonic-t');
*/



//для использования классов
require_once(PROJECT_ROOT.'/system/classes/autoload.php');

require_once(PROJECT_ROOT.'/functions/index.php');

//Для процедурки
/*
$pdo = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$pdo->exec("set names utf8");
*/

//Для процедурки
$pdo = \Bitkit\Core\Database\Connect::getInstance()->getConnection();


<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


$path = $_GET['path'];
$fullPath = $_SERVER['DOCUMENT_ROOT'] . $path;

unlink($_SERVER['DOCUMENT_ROOT'] . '/archive.zip' );

$zip = new ZipArchive(); //Создаём объект для работы с ZIP-архивами
$zip->open("archive.zip", ZIPARCHIVE::CREATE); //Открываем или создаем архив, если его не существует

$files = scandir($fullPath);
foreach ($files as $var){
    if (is_file($fullPath . '/' . $var)){
        $zip->addFile($fullPath . '/' . $var); //Добавляем в архив файл in.php
    }
}
$zip->close(); //Завершаем работу с архивом
header('Location: https://pennylane.pro/archive.zip');

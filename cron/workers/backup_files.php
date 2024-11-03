<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/global_pass.php';

$backup_folder = '/var/www/www-root/data/www/backups_pennylane/files/';    // куда будут сохранятся файлы
$backup_name = 'pennylane_backup_' . date("Y-m-d-H-i");    // имя архива
$dir = '/var/www/www-root/data/www/pennylane.pro/helpers';    // что бэкапим
$delay_delete = 12 * 3600;    // время жизни архива (в секундах)   


$start = microtime(true);    // запускаем таймер

$deleteOld = deleteOldArchives($backup_folder, $delay_delete);    // удаляем старые архивы
$doBackupFiles = backupFiles($backup_folder, $backup_name);    // делаем бэкап файлов
//$doBackupDB = backupDB($backup_folder, $backup_name);    // и базы данных

// добавляем в письмо отчеты

$time = microtime(true) - $start;     // считаем время, потраченое на выполнение скрипта

$time_minutes = $time / 60;

echo 'Затраченное время' . $time_minutes . ' мин';

//file_put_contents('last_backup',date('d-m-Y H:i'));


function backupFiles($backup_folder, $backup_name)
{
    $dir = '/var/www/www-root/data/www/pennylane.pro/';
    $fullFileName = $backup_folder . '/' . $backup_name . '.tar.gz';
    shell_exec("tar -cvpjf " . $fullFileName . ' --exclude uploads   ' . $dir .  "   ");
    return $fullFileName;
}




function deleteOldArchives($backup_folder, $delay_delete)
{
    $this_time = time();
    $files = glob($backup_folder . "/*.tar.gz*");
    $deleted = array();
    foreach ($files as $file) {
        if ($this_time - filemtime($file) > $delay_delete) {
            array_push($deleted, $file);
            unlink($file);
        }
    }
    return $deleted;
}

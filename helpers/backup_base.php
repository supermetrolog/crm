<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/errors.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/global_pass.php';

$backup_folder = '/var/www/www-root/data/www/backups_pennylane/';    // куда будут сохранятся файлы
$backup_name = 'pennylane_backup_' . date("Y-m-d-H-i");    // имя архива
$dir = '/home/my_site/www';    // что бэкапим
$delay_delete = 7 * 24 * 3600;    // время жизни архива (в секундах)

$db_host = 'localhost';
$db_user = 'timon';
$db_password = '20091993dec';
$db_name = 'pennylane';


$start = microtime(true);    // запускаем таймер


$deleteOld = deleteOldArchives($backup_folder, $delay_delete);    // удаляем старые архивы
//$doBackupFiles = backupFiles($backup_folder, $backup_name, $dir);    // делаем бэкап файлов
$doBackupDB = backupDB($backup_folder, $backup_name);    // и базы данных

// добавляем в письмо отчеты
/*
if ($doBackupFiles) {
    $mail_message .= 'site backuped successfully<br/>';
    $mail_message .= 'Files: ' . $doBackupFiles . '<br/>';
}

if ($doBackupDB) {
    $mail_message .= 'DB: ' . $doBackupDB . '<br/>';
}


if ($deleteOld) {
    foreach ($deleteOld as $val) {
        $mail_message .= 'File deleted: ' . $val . '<br/>';
    }
}
*/

$time = microtime(true) - $start;     // считаем время, потраченое на выполнение скрипта

$time_minutes = $time / 60;

echo 'Затраченное время' . $time_minutes . ' мин';

file_put_contents('last_backup', date('d-m-Y H:i'));


function backupFiles($backup_folder, $backup_name, $dir)
{
    $fullFileName = $backup_folder . '/' . $backup_name . '.tar.gz';
    shell_exec("tar -cvf " . $fullFileName . " " . $dir . "/* ");
    return $fullFileName;
}

function backupDB($backup_folder, $backup_name)
{
    $fullFileName = $backup_folder . '/' . $backup_name . '.sql';
    $command = 'mysqldump -h' . DB_HOST . ' -u' . DB_USER . ' -p' . DB_PASSWORD . ' ' . DB_NAME . ' > ' . $fullFileName;
    shell_exec($command);
    return $fullFileName;
}


function deleteOldArchives($backup_folder, $delay_delete)
{
    $this_time = time();
    $files = glob($backup_folder . "/*.sql*");
    $deleted = array();
    foreach ($files as $file) {
        if ($this_time - filemtime($file) > $delay_delete) {
            array_push($deleted, $file);
            unlink($file);
        }
    }
    return $deleted;
}

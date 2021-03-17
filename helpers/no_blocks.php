<?

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$host_old = '178.250.246.48';
$user_old = 'pci';
$password_old = 'pci777devH18p';
$db_old = 'pcidb';
$charset_old = 'utf8';
$dsn_old = "mysql:host=$host_old;dbname=$db_old;charset=$charset_old";
//$dsn = "mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=$db;charset=$charset";
$opt_old = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
try {
    $pdo_old = new \PDO($dsn_old, $user_old, $password_old, $opt_old);
    $pdo_old->exec("set names utf8");
} catch (PDOException $e) {
    echo 'Подключение не удалось: ' . $e->getMessage();
}

?>

<?php

$items = [];

$sql = $pdo_old->prepare("SELECT * FROM c_industry WHERE deleted!=1   ");
$sql->execute();

while ($item_old = $sql->fetch(PDO::FETCH_LAZY)) {

    $deals = trim(trim($item_old->deal_type),',');    

    $deals = explode(',',$deals);

    if(!in_array(3,$deals)){
        $id = $item_old->id;


        $sqlb = $pdo_old->prepare("SELECT COUNT(*) as test FROM c_industry_blocks WHERE deleted!=1 AND parent_id=$id ");
        $sqlb->execute();
        $count = $sqlb->fetch(PDO::FETCH_LAZY);


        if($count['test'] == 0){
            $items[] = $id;
        }
    }





}

$line = implode(',',$items);

file_put_contents('no_blocks.txt',$line);
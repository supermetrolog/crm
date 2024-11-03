<?

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

$sql = $pdo_old->prepare("SELECT * FROM c_industry_blocks b LEFT JOIN c_industry i ON b.parent_id=i.id WHERE b.deleted!=1 AND b.area=0 AND b.area2=0 AND i.deleted!=1  ");
$sql->execute();

while ($item_old = $sql->fetch(PDO::FETCH_LAZY)) {
    if(!in_array($items,$item_old->parent_id)){
        $items[] = $item_old->parent_id;
    }


}

$line = implode(',',$items);

file_put_contents('empty_area.txt',$line);
<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');


require_once('PHPExcel.php');
// Подключаем класс для вывода данных в формате excel
require_once('PHPExcel/Writer/Excel5.php');




// Создаем объект класса PHPExcel
$xls = new PHPExcel();
// Устанавливаем индекс активного листа
$xls->setActiveSheetIndex(0);
// Получаем активный лист
$sheet = $xls->getActiveSheet();
// Подписываем лист
$sheet->setTitle('Таблица умножения');

// Вставляем текст в ячейку A1
$sheet->setCellValue("A1", 'Лот');
$sheet->setCellValue("B1", 'Адрес');
$sheet->setCellValue("C1", 'Регион');
$sheet->setCellValue("D1", 'Населенный пункт');
$sheet->setCellValue("E1", 'Направление');
$sheet->setCellValue("F1", 'Метро');
//$sheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EEEEEE');

// Объединяем ячейки
//$sheet->mergeCells('A1:H1');

// Выравнивание текста
//$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);






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


$sql = $pdo_old->prepare("SELECT * FROM c_industry_lands WHERE deleted!='1' ");
$sql->execute();
$i = 0;

$obj_arr =[];
while($object = $sql->fetch(PDO::FETCH_LAZY)){

    $obj_old = $object;

    if($obj_old->region){
        $sql_1 = $pdo_old->prepare("SELECT * FROM l_regions WHERE id='$obj_old->region' ");
        $sql_1->execute();
        $item = $sql_1->fetch(PDO::FETCH_LAZY);
        $region = $item->title;
    }else{
        $region = '';
    }

    if($obj_old->village){
        $sql_1 = $pdo_old->prepare("SELECT * FROM l_villages WHERE id='$obj_old->village' ");
        $sql_1->execute();
        $item = $sql_1->fetch(PDO::FETCH_LAZY);
        $village = $item->title;
    }else{
        $village = '';
    }

    if($obj_old->direction){
        $sql_1 = $pdo_old->prepare("SELECT * FROM l_directions WHERE id='$obj_old->direction' ");
        $sql_1->execute();
        $item = $sql_1->fetch(PDO::FETCH_LAZY);
        $direction = $item->title;
    }else{
        $direction = '';
    }

    if($obj_old->metro){
        $sql_1 = $pdo_old->prepare("SELECT * FROM l_metros WHERE id='$obj_old->metro' ");
        $sql_1->execute();
        $item = $sql_1->fetch(PDO::FETCH_LAZY);
        $metro = $item->title;
    }else{
        $metro = '';
    }


    array_push($obj_arr,[$object->id,$object->address,$region,$village,$direction,$metro]);

}

for ($i = 2; $i < 8; $i++) {
    for ($j = 2; $j < count($obj_arr)+2; $j++) {
        // Выводим таблицу умножения
        $sheet->setCellValueByColumnAndRow($i - 2, $j, $obj_arr[$j-2][$i-2]);
        // Применяем выравнивание
        //$sheet->getStyleByColumnAndRow($i - 2, $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
}

$objWriter = new PHPExcel_Writer_Excel5($xls);
$objWriter->save('test.xls');


<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);


include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');


require_once($_SERVER['DOCUMENT_ROOT'].'/libs/back/phpexcel/PHPExcel.php');
// Подключаем класс для вывода данных в формате excel
require_once($_SERVER['DOCUMENT_ROOT'].'/libs/back/phpexcel/PHPExcel/Writer/Excel5.php');




// Создаем объект класса PHPExcel
$xls = new PHPExcel();
// Устанавливаем индекс активного листа
$xls->setActiveSheetIndex(0);
// Получаем активный лист
$sheet = $xls->getActiveSheet();
// Подписываем лист
$sheet->setTitle('Выгрузка на мос.ру');

// Вставляем текст в ячейку A1
$sheet->setCellValue("A1", 'ID');
$sheet->setCellValue("B1", 'Building Address');
$sheet->setCellValue("C1", 'Floor');
$sheet->setCellValue("D1", 'Area');
$sheet->setCellValue("E1", 'Price');
$sheet->setCellValue("F1", 'CostTypeID');
$sheet->setCellValue("G1", 'RateTypeID');
$sheet->setCellValue("H1", 'Name');
$sheet->setCellValue("I1", 'RoomTypeID');
$sheet->setCellValue("J1", 'Lat');
$sheet->setCellValue("K1", 'Lon');
$sheet->setCellValue("L1", 'INN');
$sheet->setCellValue("M1", 'Description');
$sheet->setCellValue("N1", 'Image');
$sheet->setCellValue("O1", 'District');
$sheet->setCellValue("P1", 'Region');
$sheet->setCellValue("Q1", 'Metro');
$sheet->setCellValue("R1", 'Status');
$sheet->setCellValue("S1", 'FloorsNum');
$sheet->setCellValue("T1", 'BeginDate');
$sheet->setCellValue("U1", 'BuildingClass');
$sheet->setCellValue("V1", 'Email');
$sheet->setCellValue("W1", 'Phone');
$sheet->setCellValue("X1", 'CeilingHeight');
$sheet->setCellValue("Y1", 'ExpPayment');
$sheet->setCellValue("Z1", 'Link');
//$sheet->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//$sheet->getStyle('A1')->getFill()->getStartColor()->setRGB('EEEEEE');

// Объединяем ячейки
//$sheet->mergeCells('A1:H1');

// Выравнивание текста
//$sheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



/*


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

*/

$sql = $pdo->prepare("SELECT * FROM c_industry_offers_mix WHERE  type_id=2 AND deal_type=1    AND ad_realtor=1 AND status=1 AND deleted!='1' ");
$sql->execute(); 


//массив с подготовленными для выгрузки данными
$objects_arr =[];


while($object = $sql->fetch(PDO::FETCH_LAZY)){

    $obj = [];

    //ID
    $obj[] = $object->visual_id;
    //Address
    $obj[] = $object->address;
    //Floor
    $obj[] = $object->floor_min;
    //Area
    $obj[] = $object->area_max;
    //Price
    $obj[] = $object->price_floor_min ;
    //CostTypeID
    $obj[] = 1100601 ;
    //RateTypeID
    $obj[] = 1100302;
    //Name
    $obj[] = $object->object_type_name ;
    //RoomTypeID
    $obj[] = $object->object_type_name == 'Складской комплекс' ? 6503  : 6502  ;
    //Lat
    $obj[] = $object->area_max;
    //Lon
    $obj[] = $object->area_max;
    //INN
    $obj[] = '7704610164' ;
    //Description
    $obj[] = $object->description ;
    //Image
    $imgLine = '';
    foreach (json_decode($object->photos) as $photo) {
        $photo =  'http://pennylane.pro' . $photo;
        $imgLine .= $photo . ',';
    }
    $obj[] = trim($imgLine,',');
    //District
    $obj[] = $object->district_name ? $object->district_name : $object->district_moscow_name ;
    //Region
    $obj[] = $object->region_name;
    //Metro
    $obj[] = $object->metro_name;
    //Status
    $obj[] = 'Свободно';
    //FloorsNum
    $obj[] = $object->floor_max;
    //BeginDate
    $obj[] = date('Y-m-d', time());
    //BuildingClass
    $obj[] = $object->class_name ;
    //Email
    $obj[] = 'sklad@realtor.ru' ;
    //Phone
    $obj[] = '+7 495 150 0323' ;
    //CeilingHeight
    $obj[] = $object->ceiling_height_max;
    //ExpPayment

    //Link
    $obj[] = 'https://industry.realtor.ru';






    $objects_arr[] = $obj;

}

for ($i = 2; $i < 18; $i++) {
    for ($j = 2; $j < count($objects_arr)+2; $j++) {
        // Выводим таблицу умножения
        $sheet->setCellValueByColumnAndRow($i - 2, $j, $objects_arr[$j-2][$i-2]);
        // Применяем выравнивание
        //$sheet->getStyleByColumnAndRow($i - 2, $j)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    }
}


$objWriter = new PHPExcel_Writer_Excel5($xls);
$objWriter->save('feed.xls');


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
$sheet->setCellValue("B1", 'Link');
$sheet->setCellValue("C1", 'Building Address');
$sheet->setCellValue("D1", 'Floor');
$sheet->setCellValue("E1", 'Area');
$sheet->setCellValue("F1", 'Price');
$sheet->setCellValue("G1", 'Name');
$sheet->setCellValue("H1", 'RoomType');
$sheet->setCellValue("I1", 'INN');
$sheet->setCellValue("J1", 'Image');
$sheet->setCellValue("K1", 'Description');
$sheet->setCellValue("L1", 'FloorsNum');
$sheet->setCellValue("M1", 'District');
$sheet->setCellValue("N1", 'Metro');
$sheet->setCellValue("O1", 'BuildingClass');
$sheet->setCellValue("P1", 'Phone');
$sheet->setCellValue("Q1", 'Email');
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

    $obj[] = $object->visual_id;
    $obj[] = 'https://industry.realtor.ru';
    $obj[] = $object->region_name . ' ' . $object->town_name;
    $obj[] = $object->floor_min;
    $obj[] = $object->area_max;
    $obj[] = $object->price_floor_min ;
    $obj[] = 'Индустриальная недвижимость';
    $obj[] = $object->object_type_name  ;
    $obj[] = '7704610164' ;
    $obj[] = json_decode($object->photos)[0] ;
    $obj[] = $object->description ;
    $obj[] = $object->floor_max ;

    $obj[] = $object->district_name ? $object->district_name : $object->district_moscow_name ;
    $obj[] = $object->metro_name ;
    $obj[] = $object->class_name ;

    $obj[] = '+7 495 150 0323' ;
    $obj[] = 'sklad@realtor.ru' ;



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


<?php

/*
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$user = new Member($_COOKIE['member_id']);

$pdfs = $user->getJsonField('presentations');
*/

$user_id = $_COOKIE['member_id'];


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("DB_HOST", 'localhost');
define("DB_NAME", 'pennylane');
define("DB_USER", 'timon');
define("DB_PASSWORD", '20091993dec');



//Для процедурки
$pdo = new \PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$pdo->exec("set names utf8");


$sql = $pdo->prepare("SELECT * FROM core_users WHERE id=$user_id");
$sql->execute();

$user = $sql->fetch(PDO::FETCH_LAZY);

$pdfs = json_decode($user->presentations);


//require_once($_SERVER['DOCUMENT_ROOT'].'/libs/back/snappy/autoload.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/libs/back/snappy/GeneratorInterface.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/libs/back/snappy/AbstractGenerator.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/libs/back/snappy/Pdf.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/libs/back/snappy/Image.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/libs/back/snappy/Process.php');


require_once($_SERVER['DOCUMENT_ROOT'].'/libs/back/snappy/Exception/FileAlreadyExistsException.php');

$files = [];

foreach($pdfs as $presentation){

    $snappy = new Pdf('/usr/local/bin/wkhtmltopdf');

    $snappy->setTemporaryFolder($_SERVER['DOCUMENT_ROOT'].'/export/pdf');
    $snappy->setOptions(array(
        'lowquality' => false,
        'margin-top' => 0,
        'margin-bottom' => 0,
        'margin-left' => 0,
        'margin-right' => 0,
        'page-size' => 'A4',
        'dpi' => 72,
        'header-line'=> false,
        'header-spacing' => 0,
        'footer-spacing' => 0,
        'zoom' => 0.5,
        'no-outline' => true,
    ));

    $original_id = $presentation[0];

    $type_id = $presentation[1];

    $sql = $pdo->prepare("SELECT * FROM c_industry_offers_mix WHERE original_id=$original_id AND type_id=$type_id");
    $sql->execute();

    $offer = $sql->fetch(PDO::FETCH_LAZY);

    $object_id = $offer->object_id;

    $deal_type = $offer->deal_type;


    $user_id = $_GET['member_id'];

    $doc = "https://pennylane.pro/htmlpdf.php/$original_id/$type_id/$user_id/";

    $arr_deal = [
        '1'=>'rent',
        '2'=>'sale',
        '3'=>'safe',
        '4'=>'rent',
    ];

    if($offer->type_id == 2){
        $type = 'all';
    }else{
        //$type = $offer->visual_id;
        $type = 'block';
    }

    $name = 'presentation_'.$object_id.'_'.$arr_deal[$deal_type].'_'.$type.'.pdf';

    $files[] = $name;

    $test =  file_get_contents($doc);

    $to_dir = $_SERVER['DOCUMENT_ROOT'].'/export/pdf/'.$name;

    $to_url = 'https://pennylane.pro/export/pdf/'.$name;

    if(file_exists($to_dir)){
        unlink($to_dir);
    }
    $snappy->generateFromHtml($test, $to_dir);
}

$zip = new ZipArchive();

$zip_name = $_SERVER['DOCUMENT_ROOT'].'/export/pdf/zipfile.zip';
$zip->open($zip_name, ZipArchive::CREATE);

//$zip->addFile($_SERVER['DOCUMENT_ROOT'].'/export/pdf/presentation_3217_rent_all.pdf','presentation_3217_rent_all.pdf');

foreach($files as $file) {
    $zip->addFile($_SERVER['DOCUMENT_ROOT'] . '/export/pdf/' . $file, $file);
}

$zip->close();

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="'.basename($zip_name).'"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($zip_name));
readfile($zip_name);

unlink($zip_name);
exit;










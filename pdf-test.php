<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

define("DB_HOST", 'db');
define("DB_NAME", 'objects');
define("DB_USER", 'root');
define("DB_PASSWORD", 'root');


//Для процедурки
$pdo = new \PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
$pdo->exec("set names utf8");


require_once($_SERVER['DOCUMENT_ROOT'] . '/libs/back/snappy/autoload.php');


$snappy = new Pdf('/usr/local/bin/wkhtmltopdf');


$snappy->setTemporaryFolder($_SERVER['DOCUMENT_ROOT'] . '/export/pdf');
$snappy->setOptions([
	'lowquality'     => false,
	'margin-top'     => 0,
	'margin-bottom'  => 0,
	'margin-left'    => 0,
	'margin-right'   => 0,
	'page-size'      => 'A4',
	'dpi'            => 72,
	'header-line'    => false,
	'header-spacing' => 0,
	'footer-spacing' => 0,
	'zoom'           => 0.5,
	'no-outline'     => true,
]);

if ($_GET['original_id']) {
	$original_id = $_GET['original_id'];
} else {
	$original_id = 1484;
}

if ($_GET['type_id']) {
	$type_id = $_GET['type_id'];
} else {
	$type_id = 2;
}

$member_id = $_GET['member_id'];


$sql = $pdo->prepare("SELECT * FROM c_industry_offers_mix WHERE original_id=$original_id AND type_id=$type_id");
$sql->execute();

$offer = $sql->fetch(PDO::FETCH_LAZY);

$object_id = $offer->object_id;

$deal_type = $offer->deal_type;

$doc = "https://pennylane.pro/htmlpdf.php/$original_id/$type_id/$member_id";


$arr_deal = [
	'1' => 'rent',
	'2' => 'sale',
	'3' => 'safe',
	'4' => 'rent',
];

$deal = $arr_deal[$deal_type] ?? '';

$name = 'presentation_' . $object_id . '_' . $deal . '_all.pdf';

$test = file_get_contents($doc);

$to_dir = $_SERVER['DOCUMENT_ROOT'] . '/export/pdf/' . $name;

$to_url = 'https://pennylane.pro/export/pdf/' . $name;

if (file_exists($to_dir)) {
	unlink($to_dir);
}

$snappy->generateFromHtml($test, $to_dir);

header("Location:  $to_url");


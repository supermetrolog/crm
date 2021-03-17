<?

//ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);


require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

/*
$pars = trim($_SERVER['REQUEST_URI'],'/');
$pars = explode('/',$pars);


$name = array_pop($pars);
$post = (int)array_pop($pars);
$width = (int)array_pop($pars);

*/

//var_dump($pars);



$url = $_GET['photo'];
$width = $_GET['width'];

//echo $url;

header ("Content-type: image/jpg");

$height = ceil(((int)$width)*10/16);

//echo $height;



$thumb = new Bitkit\Core\Files\Watermark($url);
$thumb->generateWatermark($width,$height);





<?

//ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);


require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');



//$name = $_GET['photo'];
$width = (int)$_GET['width'];



//var_dump($pars);


$url = $_GET['photo'];




/*
if(!file_exists($url)){
    $url = PROJECT_ROOT.'/img/catalog.jpg';
    $width = 400;
}
*/

//echo $url;

header ("Content-type: image/jpg");

$height = ceil(((int)$width)*10/16);

//echo $height;



$thumb = new Bitkit\Core\Files\Thumb($url);
$thumb->generateThumb($width,$height);





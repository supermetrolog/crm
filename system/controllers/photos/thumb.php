<?


require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$pars = trim($_SERVER['REQUEST_URI'],'/');
$pars = explode('/',$pars);

if($_COOKIE['member_id'] == 941) {
    ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);
    var_dump($pars);
}

$name = urldecode(explode('?', array_pop($pars))[0]);
$post = (int)array_pop($pars);
$width = (int)array_pop($pars);



//echo urldecode($name);


$url = PROJECT_ROOT.'/uploads/objects/'.$post.'/'.$name;

if($_COOKIE['member_id'] == 941) {
    echo $url;
    echo '<br>';
}

if(!file_exists($url)){
    $url = PROJECT_ROOT.'/img/catalog.jpg';
    $width = 400;
}


if($_COOKIE['member_id'] == 941){
    echo $url;
}else{
    header ("Content-type: image/jpg");
    $height = ceil(((int)$width)*10/16);

    //echo $height;

    $thumb = new Bitkit\Core\Files\Thumb($url);
    $thumb->generateThumb($width,$height);
}








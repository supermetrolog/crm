<?

//ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);


require_once($_SERVER['DOCUMENT_ROOT'] . '/global_pass.php');

$requestUri = trim($_SERVER['REQUEST_URI'], '/');
$requestUri = str_replace('//', '/', $requestUri);

$parts = explode('/', $requestUri);

$name = explode('?', array_pop($parts))[0];

$post = (int)array_pop($parts);
$width = (int)array_pop($parts);

$imageUrl = PROJECT_URL . '/uploads/objects/' . $post . '/' . $name;

header("Content-type: image/jpg");

$height = ceil(((int)$width) * 10 / 16);

$thumb = new Bitkit\Core\Files\Watermark($imageUrl);
$thumb->generateWatermark($width, $height);





?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 10.05.2018
 * Time: 10:36
 */
function my_autoloader($class) {
    require_once './../../classes/' . $class . '.php';
}
spl_autoload_register('my_autoloader');

$currComment = new Comment($_POST['comment_id']);
$currComment->delete();

header("Location: ".$_SERVER['HTTP_REFERER']);
<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 03.08.2018
 * Time: 17:12
 */
?>
<?php
/**
 * Created by PhpStorm.
 * User: Zhitkov
 * Date: 03.08.2018
 * Time: 11:05
 */
?>
<?php

require_once ($_SERVER['DOCUMENT_ROOT'].'/classes/autoload.php');

define('TOKEN', '608418192:AAEFYQNNwOGGeov6Xhr_tVEIWqHhX_g5IZ4');
define('URL', 'https://api.telegram.org/bot'.TOKEN.'/');

function send( $chat, $msg ){
    file_get_contents(URL."sendmessage?parse_mode=HTML&text=$msg&chat_id=$chat");
}


echo 22;


$bot_token = TOKEN; // Telegram bot token
// Bot input
$tmp = file_get_contents("php://input");
$bot = json_decode($tmp, true);
$chat = $bot["message"]["chat"]["id"];
$user = $bot["message"]["from"]["last_name"].' '.$bot["message"]["from"]["first_name"];
$text = $bot["message"]["text"];

$output = json_decode(file_get_contents('php://input'), TRUE);


$callback_query = $output['callback_query'];
$data = $callback_query['data'];
$message_id = ['callback_query']['message']['message_id'];
$chat_data = $callback_query['message']['chat']['id'];

$chat_id = $chat; //  TELEGRAM CHAT ID
$reply = "Choose your variant";
$url = "https://api.telegram.org/bot$bot_token/sendMessage";

$room = $chat;
$room_data = $chat_data;
$lim = 3; //количество валют на страницу
// Massage to user
$startMsg = "Привет, ".$user."!";
$stopMsg = "Хорошего дня, ".$user."!";
$helpMsg = "Страница помощи в разработке.";
//$wcmdMsg = "Эта команда  пока мне не знакома.";
$wcmdMsg = "Привет, друг.";
////////////////////////////ДОБАВЛЕНИЕ///////////////////////////////
///
///
$text ='https://www.instagram.com/p/Bl8_zMIlveY/?taken-by=instacadillac';
if(strtolower(trim($text))) {
    $link = strtolower(trim($text));
    if (stristr($link, 'vk.com') !== FALSE) {
        $token = 'bbc5736cbbc5736cbbc5736c98bba036d5bbbc5bbc5736ce08affe4142a0987f01b2931';
        $version = 5.63;
        $post = new Bitkit\Social\Vkontakte($token,$version,$link);
        $test = str_replace('#','',$post->getPostText());
        $test = str_replace('@','',$test);
        send($room, $test);
        //send($room, $post->getPostText());
    }elseif (stristr($link, 'instagram.com') !== FALSE){
        $post = new Bitkit\Social\Instagram($link);  
        $test = preg_replace('%[^a-zа-я\d]%i', '',$post->getPostText());

        send($room, $test);
        send($room, 'это инста');
    }elseif (stristr($link, 'facebook.com') !== FALSE){
        send($room, 'это фэйсбук');
    }elseif (stristr($link, 'twitter.com') !== FALSE){
        send($room, 'это твиттер');
    }else{
        send($room, "Эта соцсеть не поддерживается");
    }





}
if(1){

    $post1 = new Bitkit\Social\Instagram($text);
    //var_dump($post1->data);
    echo $post1->getPostText();
}

?>


<?php


require_once ($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');


define('TOKEN', '736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');
//define('URL', 'https://api.telegram.org/bot'.TOKEN.'/');
 

$telegram = new Bitkit\Social\Telegram(TOKEN);

//ответ от тектсовогог ввода
$tmp = file_get_contents("php://input");
$bot = json_decode($tmp, true);
$chat = $bot["message"]["chat"]["id"];
$user_first_name = $bot["message"]["from"]["first_name"];
$user_last_name = $bot["message"]["from"]["last_name"];
$user = $user_last_name.' '.$user_first_name;
$text = $bot["message"]["text"];

$voice_file_id = $bot["message"]["voice"]["file_id"];
$voice_file_format = $bot["message"]["voice"]["mime_type"];

$audio_file_id = $bot["message"]["audio"]["file_id"];
$audio_file_format = $bot["message"]["audio"]["mime_type"];

//ответ от дата ввода(например с клавы)
$output = json_decode(file_get_contents('php://input'), TRUE);
$callback_query = $output['callback_query'];
$data = $callback_query['data'];
$message_id = ['callback_query']['message']['message_id'];
$chat_data = $callback_query['message']['chat']['id'];


if(strtolower(trim($text)) == 'name' || strtolower(trim($text)) == 'имя') {
    $msg = $user;
    $telegram->sendMessage($msg,$chat);
}

if(strtolower(trim($text)) == 'id' ) {
    $msg = 'Ваш telegram ID :';
    $telegram->sendMessage($msg,$chat);

    $msg = $chat;
    $telegram->sendMessage($msg,$chat);
}elseif($voice_file_id || $audio_file_id){
    $msg = $voice_file_format;
    //$telegram->send($msg,$chat);

    $msg = $telegram->getFileUrl($voice_file_id);
    //$log = file_get_contents('log.html');
    //file_put_contents($_SERVER['DOCUMENT_ROOT'].'/bots/telegram/inform/log.html',$log.'<br>'.$msg);
    $telegram->sendMessage($msg,$chat);


}elseif(trim($text) == 'jarvis'){

    $msg = $telegram->soundToText($voice_file_id);

    $telegram->sendMessage($msg,$chat);



}else{
    $msg = 'Вы ввели  :'.$text;
    $telegram->sendMessage($msg,$chat);

}

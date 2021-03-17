<?
//var_dump($_GET['member_id']);

include_once(PROJECT_ROOT.'/errors.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

function photoMain($file){
    if(is_file(PROJECT_ROOT.$file)){
        $img = PROJECT_URL.$file;
        return "https://pennylane.pro/inter.php/-600-452-$img";
    }
    return NULL;
}




//ИНФОРМАЦИЯ ПО ЮЗЕРУ
$logedUser = new Member($_GET['member_id']);

$name = $logedUser->title();

$phone_1 = $logedUser->getJsonField('phones')[0];
$phone_2 = $logedUser->getJsonField('phones')[2];

$email = $logedUser->getJsonField('emails')[0];

$offers = json_decode($_GET['offers']);
$offers_amount = count($offers);




if($_GET['title']){
    $title = $_GET['title'];
}else{
    $title = 'Здравствуйте Михаил Михуилович';
}


if($_GET['description']){
    $description = $_GET['description'];
}else{
    $description = 'Мне удалось подобрать Вам ряд интересных предложений. По каждому предложению вы сможете 
    скачать PDF презентацию или просмотреть карточки объектов подробнее на сайте.';
}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="telephone=no" name="format-detection">
    <title></title>
    <!--[if (mso 16)]>
    <style type="text/css">
        a {text-decoration: none;}
    </style>
    <![endif]-->
    <!--[if gte mso 9]><style>sup { font-size: 100% !important; }</style><![endif]-->
    <!--[if !mso]><!-- -->
    <link href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700,700i" rel="stylesheet">
    <!--<![endif]-->
</head>

<body style="padding: 0; margin: 0;">
<div style="background: #f8f8f8; >
    <!--[if gte mso 9]>
    <v:background xmlns:v="urn:schemas-microsoft-com:vml" fill="t">
<v:fill type="tile" color="#ffffff"></v:fill>
</v:background>
<![endif]-->
<table  width="100%" cellspacing="0" cellpadding="20">
    <tbody>
    <tr>
        <td  class="" valign="top">
            <?=$title?>
            <br><br>
            <?=$description?>
            <br><br>
            С уважением, <?=$name?>
            <br>
            Брокер департамента


        </td>
    </tr>
    </tbody>
</table>
</div>
<div style="position: absolute; left: -9999px; top: -9999px; margin: 0px;"></div>
</body>

</html>


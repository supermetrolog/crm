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
<table  width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td class="" valign="top">
            <table class="" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                <tr>
                    <td  style="background-color: rgb(247, 247, 247);"  bgcolor="#f7f7f7" align="center">
                        <table  style="background-color: transparent;" width="600" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                            <tr>
                                <td class="esd-structure es-p10" align="center">
                                    <!--[if mso]><table ><tr><td  valign="top"><![endif]-->
                                    <table class="es-left" cellspacing="0" cellpadding="0" align="center">
                                        <tbody>
                                        <tr>
                                            <td class="esd-container-frame"  align="left">
                                                <table width="100%" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                    <tr>
                                                        <td class="" align="center">
                                                            <p style="font-family: Arial">Если письмо отображается некорректно нажмите пожалуйста <a style="text-decoration: underline; color: orange;">сюда</a></p>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <table class="es-header" cellspacing="0" cellpadding="0" align="center">
                <tbody>
                <tr>
                    <td  align="center">

                    </td>
                </tr>
                </tbody>
            </table>

            <table cellspacing="0" cellpadding="0" align="center" style="border: 1px solid #e5e5e5" bgcolor="#ffffff">
                <tbody>
                <tr>
                    <td  align="center">
                        <table class="es-content-body" style="border-left:1px solid transparent;border-right:1px solid transparent;border-top:1px solid transparent;border-bottom:1px solid transparent;" width="600" cellspacing="0" cellpadding="0"  align="center">
                            <tbody>
                            <tr>
                                <td   align="left">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                            <td class=""  align="left">
                                                <table width="100%" cellspacing="0" cellpadding="0">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <p></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="" align="center" >
                                                            <!--

                                                                <div style="font-size: 23px; font-weight: bold; font-family: Arial; letter-spacing: -2px;">PENNY LANE REALTY</div>
                                                                <div style="font-size: 10px; font-weight: bold; font-family: Arial; letter-spacing: 0px; color: red;">Premier Russian and Commercial Properties</div>

                                                            -->
                                                            <br>
                                                            <img src="https://pennylane.pro/img/pdf/logo.jpg" alt="PENNY LANE REALTY" style="border: 1px solid #e5e5e5"  title="PENNY LANE REALTY" height="30" width="200">

                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="" align="center">
                                                            <br>
                                                            <div style="color: #999999; font-family: Arial; font-size: 16px;">Департамент индустриальной недвижимости</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p></p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="left">
                                                            <table width="100%" cellspacing="0" cellpadding="20">
                                                                <tbody>
                                                                <tr>
                                                                    <td class="esd-container-frame" width="560" valign="top" align="center">
                                                                        <table width="100%" cellspacing="0" cellpadding="10" bgcolor="#f7f7f7">
                                                                            <tbody  style="background: #f5f8fa; font-family: Arial;" >
                                                                            <tr>
                                                                                <td align="left">
                                                                                    <div style="color: rgb(51, 51, 51);"><b><?=$title?></b></div>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td  align="left">
                                                                                    <div style="color: #777777; line-height: 200%;">
                                                                                        <?=$description?>
                                                                                    </div>
                                                                                    <p>
                                                                                        <span style="color: #777777;">Следите за новыми предложениями на сайте</span> <a href="https://industry.realtor.ru"><b style="color: #3b5998;">industry.realtor.ru</b></a>
                                                                                    </p>
                                                                                </td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="" style="font-family: Arial; font-size: 20px; font-weight: bold;"  align="center">
                                                            <div style="color: #181415">Подходящие объекты</div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="" style="font-family: Arial; font-size: 16px;" align="center">
                                                            <div style="padding: 5px; color: #777777">Всего <?=$offers_amount?> предложений</div>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>



                            <tr >
                                <td   align="left" >
                                    <table cellspacing="20">
                                        <tbody>



                            <?foreach ($offers as $item){?>
                                <?$offer = new OfferMix(0)?>
                                <?$offer->getRealId($item[0],$item[1])?>
                                <?php
                                $address = '';

                                if($offer->getField('region') == 'москва'){
                                    $address.= 'Москва, '.$offer->getField('metro');
                                }else{
                                    $address.= 'МO, ш. '.$offer->getField('highway');
                                    if($offer->getField('from_mkad')){
                                        $address.= ', '.$offer->getField('from_mkad').'км от МКАД';
                                    }
                                }



                                ?>
                                    <tr>
                                    <td style="border: 2px solid #e5e5e5; "   align="left" >

                                        <!--[if mso]><table  width="100%" cellpadding="0" cellspacing="0"><tr><td  valign="top"><![endif]-->
                                        <table   cellspacing="0" cellpadding="0" align="left">
                                            <tbody>
                                            <tr>
                                                <td   align="left">
                                                    <table  cellspacing="0" cellpadding="0">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center">
                                                                <img  src="<?=photoMain(($offer->getJsonField('photos'))[0])?>" alt="" width="260" height="280">
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!--[if mso]></td><td width="20"></td><td width="" valign="top"><![endif]-->
                                        <table width="250" cellspacing="0" cellpadding="0" align="left">
                                            <tbody>
                                            <tr>
                                                <td  width="100%" align="left">
                                                    <table  width="" style="font-family: Arial;" cellspacing="0" cellpadding="18">
                                                        <tbody>
                                                        <tr>
                                                            <td class="" align="left">
                                                                <div><b><?=valuesCompare($offer->getField('area_min'),$offer->getField('area_max'))?> м<sup>2</sup></b></div>
                                                                <div style="color: #777777"><?=$address?></div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>
                                                                <table width="250" cellspacing="0" cellpadding="0" >
                                                                    <tbody>
                                                                    <tr>
                                                                        <td  width="125" align="left">
                                                                            <div style="font-family: Arial; width: 150px" >
                                                                                <table >
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <img src="<?=PROJECT_URL.'/img/email/icons/floors.png'?>" style="width: 20px;" />
                                                                                            </td>
                                                                                            <td>
                                                                                                <?=valuesCompare($offer->getField('floor_min'),$offer->getField('floor_max'))?> этаж
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>

                                                                            </div>
                                                                            <div style="font-family: Arial">
                                                                                <table >
                                                                                    <tbody>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <img src="<?=PROJECT_URL.'/img/email/icons/height.png'?>" style="width: 20px;" />
                                                                                            </td>
                                                                                            <td>
                                                                                                <?=valuesCompare($offer->getField('ceiling_height_min'),$offer->getField('ceiling_height_max'))?> м
                                                                                            </td>
                                                                                        </tr>
                                                                                    </tbody>
                                                                                </table>


                                                                            </div>
                                                                            <div style="font-family: Arial">
                                                                                <table >
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <img src="<?=PROJECT_URL.'/img/email/icons/power.png'?>" style="width: 20px;" />
                                                                                        </td>
                                                                                        <td>
                                                                                            <?=$offer->getField('power')?> кВт
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>


                                                                            </div>
                                                                        </td>
                                                                        <td  width="125"  align="left">
                                                                            <div style="font-family: Arial">
                                                                                <table >
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <img src="<?=PROJECT_URL.'/img/email/icons/gates.png'?>" style="width: 20px;" />
                                                                                        </td>
                                                                                        <td>
                                                                                            <?=$offer->getField('gate_type')?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div style="font-family: Arial">
                                                                                <table >
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <img src="<?=PROJECT_URL.'/img/email/icons/floor.png'?>" style="width: 20px;" />
                                                                                        </td>
                                                                                        <td>
                                                                                            <?=$offer->getField('floor_type')?>
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                            <div style="font-family: Arial">
                                                                                <table >
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td>
                                                                                            <img src="<?=PROJECT_URL.'/img/email/icons/cranes.png'?>" style="width: 20px;" />
                                                                                        </td>
                                                                                        <td>
                                                                                            10тонн
                                                                                        </td>
                                                                                    </tr>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td >
                                                                <table width="250" cellspacing="0" cellpadding="0"  >
                                                                    <tbody>
                                                                    <tr>
                                                                        <td  width="160" align="left">
                                                                            <table >
                                                                                <tbody>
                                                                                <tr>
                                                                                    <td>
                                                                                        <img alt="photo" src="https://pennylane.pro/img/pdf/pdf.png" width="15"  />
                                                                                    </td>
                                                                                    <td>
                                                                                        <a href="https://pennylane.pro/create_pdf.php?id=<?=$item[0]?>&type_id=<?=$item[1]?>"  target="_blank" style=" text-decoration: none; color:  #000000; font-family: Arial">
                                                                                            Скачать
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                        <td  width="125" align="left">
                                                                            <a href="https://pennylane.pro/presentation/<?=$item[0]?>/<?=$item[1]?>"  target="_blank" style="font-size: 12px; color:  #c2c2c2; font-family: Arial;">Подробнее >> </a>
                                                                        </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <!--[if mso]></td></tr></table><![endif]-->
                                    </td>
                                    </tr>

                            <?}?>


                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <br>
                                </td>
                            </tr>




                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <table  cellspacing="0" cellpadding="0" align="center">
                <tbody>
                <tr>
                </tr>
                <tr>
                    <td   style="background-color: #f0f2f4;" bgcolor="#f0f2f4" align="center">
                        <table  width="100%" cellspacing="0" cellpadding="0" align="center">
                            <tbody>
                            <tr>
                                <td  align="left">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                        <tbody>
                                        <tr>
                                            <td width="560" valign="top" align="center">
                                                <table width="180" cellspacing="0" cellpadding="0">
                                                    <tbody >
                                                        <tr >
                                                            <td width=""  align="center">
                                                                <table  cellspacing="10" cellpadding="10">
                                                                    <tbody >
                                                                        <tr>
                                                                            <td style="  background: #d03d43;">
                                                                                <a href="" style="font-family: Arial; font-weight: bold;   color: #FFFFFF; text-decoration: none">
                                                                                    СКАЧАТЬ ВСЕ
                                                                                </a>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
            <table  cellspacing="0" cellpadding="0" align="center">
                <tbody>
                <tr>
                    <td  align="center">
                        <table bgcolor="#3f4246"  style="border-top:1px solid #333333;" width="600" cellspacing="0" cellpadding="0" align="center">
                            <tbody bgcolor="#3f4246" color="#ffffff" style="background: #3f4246; color: white; font-family: Arial;">
                            <tr>
                                <td  align="left">
                                    <!--[if mso]><table width="" cellpadding="0"
                                                        cellspacing="0"><tr><td width="180" valign="top"><![endif]-->
                                    <table cellspacing="0" cellpadding="0" align="left">
                                        <tbody style="font-family: Arial;">
                                        <tr>
                                            <td width="180" valign="top" align="center">
                                                <table width="100%" cellspacing="0" cellpadding="20">
                                                    <tbody color="#ffffff">
                                                    <tr color="#ffffff">
                                                        <td  color="#ffffff" align="left">
                                                            <div style="text-decoration: none; color: #FFFFFF; font-family: Arial">С уважением, </div>
                                                            <div style="text-decoration: none; color: #FFFFFF; font-family: Arial"><?=$name?></div>
                                                            <div style="text-decoration: none; color: #FFFFFF; font-family: Arial"><br>брокер департамента</div>
                                                            <a target="_blank"  href="tel: <?=$phone_1?>" value="+380800303505"  style="text-decoration: none; color: #FFFFFF; font-family: Arial;"><br>моб <?=$phone_1?></a><br>
                                                            <a target="_blank"  href="tel: <?=$phone_2?>"  value="+380800303505"  style="text-decoration: none; color: #FFFFFF; font-family: Arial" >раб <?=$phone_2?></a><br>
                                                            <a target="_blank" href="mailto:<?=$email?>" style="text-decoration: none; color: #FFFFFF; font-family: Arial"><?=$email?></a>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!--[if mso]></td><td width="20"></td><td width="360" valign="top"><![endif]-->
                                    <table cellspacing="0" cellpadding="0" align="right">
                                        <tbody >
                                        <tr>
                                            <td class="esd-container-frame" width="360" align="right">
                                                <table width="100%" cellspacing="0" cellpadding="20">
                                                    <tbody >
                                                    <tr>
                                                        <td  align="right">
                                                            <div style="text-decoration: none; color: #FFFFFF; font-family: Arial;">Penny Lane Realty 1993 - 2019<div  style="text-decoration: none; color: #FFFFFF;" color="#FFFFFF"> Москва Знаменка д 13 стр 3 </div> <br><a target="_blank" href="https://industry.realtor.ru" style="text-decoration: none; color: #FFFFFF">Сайт: industry.realtor.ru</a></div>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="esd-block-social es-p15b es-m-txt-c" align="right">
                                                            <table class="es-table-not-adapt es-social" cellspacing="0" cellpadding="0">
                                                                <tbody>
                                                                <tr>
                                                                    <!--
                                                                    <td class="es-p10r" valign="top" align="center"> <a target="_blank" href="#"><img title="Facebook" src="https://tlr.stripocdn.email/content/assets/img/social-icons/circle-gray-bordered/facebook-circle-gray-bordered.png" alt="Fb" width="32"></a> </td>
                                                                    <td class="es-p10r" valign="top" align="center"> <a target="_blank" href="#"><img title="Youtube" src="https://tlr.stripocdn.email/content/assets/img/social-icons/circle-gray-bordered/youtube-circle-gray-bordered.png" alt="Yt" width="32"></a> </td>
                                                                    -->
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>

                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!--[if mso]></td></tr></table><![endif]-->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</div>
<div style="position: absolute; left: -9999px; top: -9999px; margin: 0px;"></div>
</body>

</html>


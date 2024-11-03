<?php

//ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);


require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');



require(PROJECT_ROOT.'/libs/back/fpdf/fpdf.php');

require(PROJECT_ROOT.'/libs/back/fpdf/tfpdf.php');


$original_id = (int)$_GET['id'];
$original_type = (int)$_GET['type_id'];

/*
echo $original_id;
echo '<br>';
echo $original_type;
echo '<br>';
*/


$offer = new OfferMix(0);
$offer->getRealId((int)$original_id,(int)$original_type);

$latitude = $offer->getField('latitude');
$longitude = $offer->getField('longitude');

$test =  file_get_contents("https://static-maps.yandex.ru/1.x/?ll=$latitude,$longitude&size=262,450&z=8&l=map&pt=$latitude,$longitude,pm2rdl");
file_put_contents('map.png',$test);


$offer_mix_id =  $offer->postId();
//echo $offer->postId();

$object = new Building($offer->getField('object_id'));

//изменит на агента по предложению
$agent = new Member($offer->getField('agent_id'));




function photoHelper($file){
    if(is_file(PROJECT_ROOT.$file)){
        $img = PROJECT_URL.$file;
    }else{
        $img = PROJECT_URL.'/img/pdf/back.jpg';
    }
    return "https://pennylane.pro/inter.php/-800-600-$img";
}

function photoMain($file){
    if(is_file(PROJECT_ROOT.$file)){
        $img = PROJECT_URL.$file;
        return "https://pennylane.pro/inter.php/-600-452-$img";
    }
    return NULL;
}

function backSmall($file){
    if(is_file(PROJECT_ROOT.$file)){
        $img = PROJECT_URL.$file;
        return "https://pennylane.pro/inter.php/-600-100-$img";
    }
    return NULL;
}

//echo photoHelper(($offer->getJsonField('photos'))[0]);


// Add a Unicode font (uses UTF-8)


$cap_arr = [];
$offer->getField('cranes_railway_min') ? $cap_arr[] = $offer->getField('cranes_railway_min') : '';
$offer->getField('cranes_gantry_min') ? $cap_arr[] = $offer->getField('cranes_gantry_min') : '';
$offer->getField('cranes_overhead_min') ? $cap_arr[] = $offer->getField('cranes_overhead_min') : '';
$offer->getField('cranes_cathead_min') ? $cap_arr[] = $offer->getField('cranes_cathead_min') : '';
$offer->getField('telphers_min') ? $cap_arr[] = $offer->getField('telphers_min') : '';
$capacity_all_min = min($cap_arr);



$cap_arr = [];
$offer->getField('cranes_railway_max') ? $cap_arr[] = $offer->getField('cranes_railway_max') : '';
$offer->getField('cranes_gantry_max') ? $cap_arr[] = $offer->getField('cranes_gantry_max') : '';
$offer->getField('cranes_overhead_max') ? $cap_arr[] = $offer->getField('cranes_overhead_max') : '';
$offer->getField('cranes_cathead_max') ? $cap_arr[] = $offer->getField('cranes_cathead_max') : '';
$offer->getField('telphers_max') ? $cap_arr[] = $offer->getField('telphers_max') : '';

$capacity_all_max = max($cap_arr);


class PDF extends tFPDF
{
// Page header
    function Header()
    {

        $original_id = (int)$_GET['id'];
        $original_type = (int)$_GET['type_id'];

        $offer = new OfferMix(0);
        $offer->getRealId((int)$original_id,(int)$original_type);

        $offer_mix_id =  $offer->postId();

        $object = new Building($offer->getField('object_id'));

        //изменит на агента по предложению
        $agent = new Member($offer->getField('agent_id'));

        // ЛОГО
        $this->AddFont('TextCond','','PFDinTextCondPro.ttf',true);


        $this->Image('img/pdf/logo.jpg',5,5,60);



        // Arial bold 15
        $this->SetFont('TextCond','',12);
        $this->SetY(5);
        $this->SetX(135);
        // КОНСУЛЬТАНТ
        $this->Cell('60','6',$agent->title(),'','','L');



        $this->SetFont('TextCond','',8);

        $this->SetY(10);
        $this->SetX(135);
        $this->SetTextColor(152,46,6);
        $this->Cell('40','4','Ведущий консультант','',0,'L');

        //ВЕРТИКАЛЬНАЯ ЛИНИЯ
        $this->SetY(6);
        $this->SetX(176);
        $this->Cell('0.1','8','','1',0,'');

        //ТЕЛЕФОНЫ
        $this->SetY(5);

        $this->SetFont('TextCond','',12);
        $this->SetTextColor(0,0,0);
        $this->SetX(170);
        $this->Cell('36','6','+7 926 556 92 80','',0,'R');

        $this->SetY(10);
        $this->SetX(170);
        $this->Cell('36','6','+7 495 150 03 23','',0,'R');

        // Line break
        $this->Ln(20);
    }





    // Page footer
    function Footer()
    {

        $this->AddFont('TextCond','','PFDinTextCondPro.ttf',true);
        $this->AddFont('TextCondBold','','PFDinTextCondPro-Bold.ttf',true);
        // Position at 1.5 cm from bottom
        $this->SetY(-25);
        // Arial italic 8
        $this->SetFont('TextCond','',9.5);
        // Page number
        $this->SetX(180);
        $this->Cell(26,10,'стр. '.$this->PageNo().'',0,0,'R');

        //ГОРИЗОНТАЛЬНАЯ ЛИНИЯ
        $this->SetY(-15);
        $this->SetX(5);
        $this->Cell(200,0.1,'',1,1,'');

        $this->SetY(-10);
        $this->SetX(4);
        $this->SetFont('TextCondBold','',9.5);
        $this->Cell('','','ИНДУСТРИАЛЬНАЯ НЕДВИЖИМОСТЬ','',0,'');

        $this->SetX(55);
        $this->Cell('','','*','',0,'');
        $this->SetX(57);
        $this->SetTextColor(188,188,188);
        $this->SetFont('TextCond','',9.5);
        $this->Cell('','','ТЕЛ:','',0,'');

        //ТЕЛЕФОН
        $this->SetX(63);
        $this->SetFont('TextCondBold','',9.5);
        $this->SetTextColor(0,0,0);
        $this->Cell('','','+ 7 495 150-03-23','',0,'');

        $this->SetFont('TextCond','',9.5);
        $this->SetX(89);
        $this->Cell('','','*','',0,'');

        $this->SetX(91);
        $this->SetTextColor(188,188,188);
        $this->Cell('','','САЙТ:','',0,'');

        $this->SetX(99);
        $this->SetTextColor(200,208,254);
        $this->Cell('','','INDUSTRY.REALTOR.RU','',0,'');

        $this->SetX(128);
        $this->Cell('','','*','',0,'');

        $this->SetX(130);
        $this->SetTextColor(188,188,188);
        $this->Cell('','','ПОЧТА:','',0,'');

        $this->SetX(140);
        $this->SetTextColor(200,208,254);
        $this->Cell('','','SKLAD@REALTOR.RU','',0,'');

        $this->Image('img/penny.png',169,285,36);


    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();


//БОЛЬШАЯ КАРТИНКА
//$pdf->Image('uploads/objects/2478/1.jpg',5,22,133);
$pdf->Image(photoMain(($offer->getJsonField('photos'))[0]),5,22,133);

//$pdf->SetFont('Arial','B',10);

$pdf->SetTextColor(255,255,255);


$pdf->AddFont('TextCond','','PFDinTextCondPro.ttf',true);
$pdf->AddFont('TextCondBold','','PFDinTextCondPro-Bold.ttf',true);


//ID объекта
$pdf->SetFont('TextCond','',10);
$pdf->SetTextColor(255,255,255);


$pdf->SetXY(5,22);
$pdf->SetFillColor(152,46,6);
$pdf->Cell('25','8','ОБЪЕКТ '.$offer->getField('object_id'),0,1,'C',1);


$pdf->SetXY(9,87);

//НАЗВАНИЕ ОБЪЕКТА
$pdf->SetFont('TextCondBold','',35);
$pdf->Cell('50','5',mb_strtoupper($offer->getField('title')),0,1,'L',0);

//КЛАССИФИКАЦИЯ ОБЪЕКТА
$pdf->SetFont('TextCond','',12);
$pdf->SetX(9);
$pdf->Cell('50','12',$offer->getField('object_type_name'),'0',1,'L',0);

//КНОПКИ
$pdf->SetFont('TextCond','',12);
$pdf->SetTextColor(128,'0','0');
$pdf->SetFillColor(200,208,254);


if($offer->getField('town')){
    $pdf->SetX(10);
    $width_town = strlen($offer->getField('town'))+4;
    $pdf->Cell($width_town,'10',mb_convert_case($offer->getField('town'), MB_CASE_TITLE, "UTF-8"),'',0,'C',1);
}


if($offer->getField('highway')){

    $pdf->SetX(10+$width_town+2);
    $width_highway = strlen($offer->getField('highway'))+4;
    $pdf->Cell($width_highway,'10',mb_convert_case($offer->getField('highway'), MB_CASE_TITLE, "UTF-8").' ','',0,'C',1);
}


if($offer->getField('from_mkad')){
    $pdf->SetX(10+$width_town + 2 + $width_highway +2 );
    $width_mkad = strlen($offer->getField('from_mkad'))+24;
    $pdf->Cell($width_mkad,'10',$offer->getField('from_mkad').' км от МКАД','',1,'C',1);
}

if($offer->getField('metro')){
    $pdf->SetX(10+$width_town + 2 + $width_highway +2 );
    $width_metro = strlen($offer->getField('metro'))+4;
    $pdf->Cell($width_metro,'10',$offer->getField('metro'),'',1,'C',1);
}


//КАРТА КАРТА КАРТА
$pdf->Image(PROJECT_URL.'/map.png',140,22,65);

$pdf->SetFillColor(250,250,250);

if($offer->getField('from_metro_time')){
    $pdf->Rect(189, 24, 14, 10 , 'F');
    $pdf->Image(PROJECT_URL.'/img/pdf/icons/metro.png',194,25,4);
    $pdf->setY(29);
    $pdf->setX(189);
    $pdf->SetFont('TextCond','',7);
    $pdf->Cell('14','2',$offer->getField('from_metro_time').' мин.','',1,'C',1);
    $pdf->SetFont('TextCond','',6);
    $pdf->setX(189);
    $pdf->Cell('14','2',mb_strtolower($offer->getField('from_metro_way')),'',1,'C',1);

}

if($offer->getField('railway_station_time')){
    $pdf->Rect(189, 35, 14, 10 , 'F');
    $pdf->Image(PROJECT_URL.'/img/pdf/icons/train.png',194,36,4);
    $pdf->setY(40);
    $pdf->setX(189);
    $pdf->SetFont('TextCond','',7);
    $pdf->Cell('14','2',$offer->getField('railway_station_time').' мин.','',1,'C',1);
    $pdf->SetFont('TextCond','',6);
    $pdf->setX(189);
    $pdf->Cell('14','2',mb_strtolower($offer->getField('railway_station_way')),'',1,'C',1);
}

if($offer->getField('bus_station_time')){
    $pdf->Rect(189, 46, 14, 10 , 'F');
}


//$pdf->SetFont('Times','',12);


//ЦЕНЫ И ПЛОЩАДИ
$pdf->SetY(22);
$pdf->SetX(5);
$pdf->SetFillColor(230,230,230);
$pdf->Rect(5, 125, 45, 30 , 'F');

//ПЛОЩАДИ
$pdf->SetY(128);
$pdf->SetX(9);
$pdf->SetFont('TextCondBold','',10);


//ВСТУПЛЕНИЕ ПЛОЩАДИ
if($offer->getField('deal_type') == 2){
    $area_intro = 'Общая площадь';
}else{
    $area_intro = 'Площади в аренду';
}
$pdf->Cell('30','10',mb_strtoupper($area_intro),0,1,'L',1);

$pdf->SetFont('TextCondBold','',24);
$pdf->SetX(8.5);
$pdf->Cell('40','5',$offer->getField('area_max').' м.кв.',0,1,'L',1);


//ДЕЛЕНИЕ ПЛОЩАДИ
if($offer->getField('area_min') != $offer->getField('area_max')){
    $area_intro = 'Деление от '.$offer->getField('area_min').' м.кв. ';
}else{
    if($offer->getField('deal_type') == 2){
        $area_intro = 'Продаётся целиком';
    }else{
        $area_intro = 'Площадь не делится';
    }
}
$pdf->SetFont('TextCond','',10);
$pdf->SetX(9);
$pdf->Cell('30','10',$area_intro,0,1,'L',1);
//
$pdf->SetFillColor(255,255,255);
$pdf->Rect(50, 125, 88, 30 , 'FD');




//ЦЕНЫ

//ЦЕНА ВСТУПЛЕНИЕ
$pdf->SetY(128);
$pdf->SetX(55);
$pdf->SetFont('TextCondBold','',10);
if($offer->getField('deal_type') == 2){
    $area_intro = 'Цена продажи';
}elseif($offer->getField('deal_type') == 2){
    $area_intro = 'Ставка хранения за м.кв./ год';
}else{
    $area_intro = 'Ставка аренды за м.кв./ год';
}
if($offer->getField('tax_form') == 'triple net'){
    $area_tax = ', без НДС';
}else{
    $area_tax = ', '.$offer->getField('tax_form');
}
$area_intro.=$area_tax;
$pdf->Cell('60','10',mb_strtoupper($area_intro),0,1,'L',1);

//ЦЕНА ОСНОВНОЕ
$pdf->SetX(55);
$pdf->SetFont('TextCondBold','',24);
$price_value = '';
if($offer->getField('deal_type') == 2) {
    if($offer->getField('price_sale_min') != $offer->getField('price_sale_max')){
        $price_value.= 'от ';
    }
    $price_value.= $offer->getField('price_sale_min');
}else{
    $price_value.= valuesCompare($offer->getField('price_floor_min'),$offer->getField('price_floor_max'));
}
$pdf->Cell('30','5',$price_value.' руб. ',0,1,'L',1);


//ЦЕНА ДОПОЛНИТЕЛЬНО
$pdf->SetFont('TextCond','',10);
$pdf->SetX(55);
if($offer->getField('deal_type') == 2) {
    $area_intro = 'Ставка продажи ';
    if ($offer->getField('price_sale_min') != $offer->getField('price_sale_min')) {
        $area_intro .= 'от ';
    }
    if ($offer->getField('is_land')) {
        $area_intro .= $offer->getField('price_sale_min') . 'за 1 сотку';
    } else {
        $area_intro .= $offer->getField('price_sale_min') . 'за 1 м.кв.';
    }
}elseif($offer->getField('deal_type') == 3){
    $area_intro = 'Подробные цены на услуги по запросу';
}else{
    $area_intro = 'Не включает';
}
$pdf->Cell('30','10',$area_intro,0,1,'L',1);

//СУММАРНЫЕ ХАРАКТЕРИСТИКИ
//1
$pdf->SetFillColor(255,255,255);
$pdf->Rect(139, 125, 22, 15 , 'F');
//2
$pdf->SetFillColor(255,255,255);
$pdf->Rect(161, 125, 22, 15 , 'F');
//3
$pdf->SetFillColor(255,255,255);
$pdf->Rect(183, 125, 22, 15 , 'F');

//4
$pdf->SetFillColor(255,255,255);
$pdf->Rect(139, 140, 22, 15 , 'F');
//5
$pdf->SetFillColor(255,255,255);
$pdf->Rect(161, 140, 22, 15 , 'F');
//6
$pdf->SetFillColor(255,255,255);
$pdf->Rect(183, 140, 22, 15 , 'F');

$pdf->Rect(4, 120, 200, 5 , 'F');


//ЗАПОЛНЯЕМ суммарные
$pdf->Image(PROJECT_URL.'/img/pdf/icons/floors.png',147,127,4);
$pdf->SetY(134);
$pdf->SetX(139);
$pdf->Cell('22','4',valuesCompare($offer->getfield('floor_min'),$offer->getField('floor_max')).' этаж',0,0,'C');


$pdf->Image(PROJECT_URL.'/img/pdf/icons/gates.png',169,127,5);
$pdf->SetX(161);
$pdf->Cell('22','4',$offer->getField('gate_num').' ворот',0,0,'C');


$pdf->Image(PROJECT_URL.'/img/pdf/icons/power.png',192,127,3);
$pdf->SetX(183);
$pdf->Cell('22','4',$offer->getField('power').' кВт',0,0,'C');



$pdf->Image(PROJECT_URL.'/img/pdf/icons/height.png',147,142,3);
$pdf->SetY(149);
$pdf->SetX(139);
$pdf->Cell('22','4',valuesCompare($offer->getfield('ceiling_height_min'),$offer->getField('ceiling_height_max')).' м',0,0,'C');

$pdf->Image(PROJECT_URL.'/img/pdf/icons/floor.png',170,142,3);
$pdf->SetX(161);
$pdf->Cell('22','4',$offer->getField('floor_type'),0,0,'C');

$pdf->Image(PROJECT_URL.'/img/pdf/icons/cranes.png',192,142,3);
$pdf->SetX(183);
$pdf->Cell('22','4',valuesCompare($capacity_all_min,$capacity_all_max).' тонн',0,0,'C');


//КАРТИНКИ ПЕРВЫЙ РЯД

$pdf->Image(photoHelper(($offer->getJsonField('photos'))[1]),5,160,66);

$pdf->Image(photoHelper(($offer->getJsonField('photos'))[2]),72,160,66);

$pdf->Image(photoHelper(($offer->getJsonField('photos'))[3]),139,160,66);

//$pdf->Image('https://pennylane.pro/map_gen.php?img=2-https://pennylane.pro/uploads/objects/2479/1.jpg',139,160,66);


if($offer->getField('type_id') == 2 && count($offer->getJsonField('blocks')) > 1){
    //ВАРИАНТЫ ДЕЛЕНИЯ
    $pdf->SetFont('TextCondBold','',10);


    //БЛОКИ
    $pdf->SetY(215);
    $pdf->SetX(90);
    $pdf->Cell('30','6','ВАРИАНТЫ ДЕЛЕНИЯ','B',1,'C',1);

    //ТАБЛИЦА БЛОКОВ

    //ШАПКА ТАБЛИЦЫ
    $pdf->SetY(221);
    $pdf->SetFont('TextCond','',10);

    $pdf->SetX(5);
    $pdf->Cell('15','8','ID блока',0,0,'C',0);

    $pdf->SetX(20);
    $pdf->Cell('10','8','Этаж',0,0,'C',1);

    $pdf->SetX(30);
    $pdf->Cell('30','8','Площадь',0,0,'C',1);

    $pdf->SetX(60);
    $pdf->Cell('15','8','Высота',0,0,'C',1);

    $pdf->SetX(75);
    $pdf->Cell('20','8','Тип пола',0,0,'C',1);

    $pdf->SetX(95);
    $pdf->Cell('20','8','Ворота',0,0,'C',1);

    $pdf->SetX(115);
    $pdf->Cell('20','8','Температура',0,0,'C',1);

    $pdf->SetX(135);
    $pdf->Cell('40','8','Ставка без НДС м кв год',0,0,'C',1);

    $pdf->SetX(175);
    $pdf->Cell('30','8','Итого цена в месяц',0,0,'C',1);

    $blocks = $offer->getJsonField('blocks');
    $blocks_amount = count($blocks);

    for($i = 0; $i < $blocks_amount; $i++){
        if($i%2 == 0){
            $pdf->SetFillColor(200,208,254);
        }else{
            $pdf->SetFillColor(255,255,255);
        }
        $block = new OfferMix($blocks[$i]);
        $delta_y = $i*8;

        //$pdf->SetY(225 + $delta_y);

        //СТРОКА ТАБЛИЦЫ
        $pdf->SetY(229 + $delta_y);
        $pdf->SetFont('TextCond','',10);

        $pdf->SetX(5);
        $pdf->Cell('15','8',$block->getField('object_id').'-1','',0,'C',1);

        $pdf->SetX(20);
        $pdf->Cell('10','8',$block->getField('floor_min'),'',0,'C',1);

        $pdf->SetX(30);
        $pdf->SetFont('TextCondBold','',10);
        $pdf->Cell('30','8',valuesCompare($block->getField('area_min'),$block->getField('area_max')).' м.кв.','',0,'C',1);

        $pdf->SetX(60);
        $pdf->SetFont('TextCond','',10);
        $pdf->Cell('15','8',valuesCompare($block->getField('ceiling_height_min'),$block->getField('ceiling_height_max')).' м.','',0,'C',1);

        $pdf->SetX(75);
        $pdf->Cell('20','8',$block->getField('floor_type'),'',0,'C',1);

        $pdf->SetX(95);
        $pdf->Cell('20','8',$block->getField('gate_type'),'',0,'C',1);

        $pdf->SetX(115);
        $pdf->Cell('20','8',valuesCompare($block->getField('temperature_min'),$block->getField('temperature_max')).' С','',0,'C',1);

        $pdf->SetX(135);
        $pdf->SetFont('TextCondBold','',10);
        $pdf->Cell('40','8',valuesCompare($block->getField('price_floor_min'),$block->getField('price_floor_max')).' руб.','',0,'C',1);

        $pdf->SetX(175);
        $pdf->SetFont('TextCond','',10);
        $pdf->Cell('30','8','от '.$block->getField('price_min_month_all').' руб.','',0,'C',1,'1');


    }

}else{
    //БЛОКИ
    $pdf->Ln(65);
    $pdf->SetX(90);
    $pdf->Cell('35','6','ОПИСАНИЕ ПРЕДЛОЖЕНИЯ','B',1,'C',1);

    $pdf->Ln(5);
    $pdf->SetX(5);
    $pdf->MultiCell('','6',str_replace("\n", "",$offer->getField('description')));

    $desc_flag = 1;

}



//ПЕРЕХОДИМ НА ВТОРУЮ СТРАНИЦУ

$pdf->AddPage('P');

//ВТОРОЙ РЯД ФОТОК
//if(($offer->getJsonField('photos'))[4]){
if(1== 2){
    $pdf->Image(photoHelper(($offer->getJsonField('photos'))[4]),5,20,66);

    $pdf->Image(photoHelper(($offer->getJsonField('photos'))[5]),72,20,66);

    $pdf->Image(photoHelper(($offer->getJsonField('photos'))[6]),139,20,66);

    $pdf->Ln(45);
}



if($desc_flag == 1){

}else{
    //БЛОКИ

    $pdf->SetX(90);
    $pdf->SetY(20);
    $pdf->Cell('35','6','ОПИСАНИЕ ПРЕДЛОЖЕНИЯ','B',1,'C',1);

    $pdf->SetX(5);
    $pdf->MultiCell('','6',str_replace("\n", "",$offer->getField('description')),1);

}



$pdf->Image(PROJECT_URL.'/img/pdf/back_small.jpg',5,110,200);

$pdf->SetTextColor(255,255,255);
$pdf->SetFont('TextCond','',15);
$pdf->Ln(30);
$pdf->SetX(5);
$pdf->Cell('200','6','Узнайте первым о новом, подходящем Вам предложени',0,0,'C',0);


$pdf->SetTextColor(145,143,122);
$pdf->Ln(5);
$pdf->SetFont('TextCond','',8);
$pdf->SetX(5);
$pdf->Cell('180','6','Настройте параметры поиска подходящено Вам объекта, и ка ктолько он появится на рынке система автоматически пришлет его Вам на эл.почту.',0,'L',0);


$pdf->SetTextColor(99,151,218);
$pdf->Ln(8);
$pdf->SetFont('TextCond','',20);
$pdf->Cell('','6','INDUSTRY.REALTOR.RU',0,0,'C',0,'http://industry.realtor.ru');


$pdf->Ln(20);
$pdf->SetFont('TextCond','',10);
$pdf->SetTextColor(0,0,0);
$pdf->SetX(90);
$pdf->Cell('35','6','ПОДРОБНЫЕ ПАРАМЕТРЫ','B',1,'C',1);



$pdf->SetTitle('Презентация объекта. PENNY LANE REALTY');
$pdf->SetSubject('Презентация объекта.');
$pdf->Output();



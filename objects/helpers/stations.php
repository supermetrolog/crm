<?php


// Радиус земли
define('EARTH_RADIUS', 6372795);

/*
* Расстояние между двумя точками
* $φA, $λA - широта, долгота 1-й точки,
* $φB, $λB - широта, долгота 2-й точки
* Написано по мотивам http://gis-lab.info/qa/great-circles.html
* Михаил Кобзарев <mikhail@kobzarev.com>
*
*/
function calculateTheDistance ($φA, $λA, $φB, $λB) {

// перевести координаты в радианы
    $lat1 = $φA * M_PI / 180;
    $lat2 = $φB * M_PI / 180;
    $long1 = $λA * M_PI / 180;
    $long2 = $λB * M_PI / 180;

// косинусы и синусы широт и разницы долгот
    $cl1 = cos($lat1);
    $cl2 = cos($lat2);
    $sl1 = sin($lat1);
    $sl2 = sin($lat2);
    $delta = $long2 - $long1;
    $cdelta = cos($delta);
    $sdelta = sin($delta);

// вычисления длины большого круга
    $y = sqrt(pow($cl2 * $sdelta, 2) + pow($cl1 * $sl2 - $sl1 * $cl2 * $cdelta, 2));
    $x = $sl1 * $sl2 + $cl1 * $cl2 * $cdelta;

//
    $ad = atan2($y, $x);
    $dist = $ad * EARTH_RADIUS;

    return $dist;
}




$trainstations = [];
$busstops = [];
$metrostations = [];

$api_key = '0d440afe-79ed-475f-97ce-e1e47b704432';

$api_key_geo = '7cb3c3f6-2764-4ca3-ba87-121bd8921a4e';

$address = 'Россия, Москва, пристань Гостиница Украина';

if($_POST['address']){
    $address = $_POST['address'];
    $url = "https://geocode-maps.yandex.ru/1.x/?apikey=$api_key_geo&format=json&geocode=".urlencode($address);
    if( $curl = curl_init() ) {
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $out = curl_exec($curl);
        //echo $out;
        curl_close($curl);
    }

    $point = json_decode($out,true);

    $point_pos_line = $point['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
    $point_pos = explode(' ',$point_pos_line);

    $lat = $point_pos[1];
    $lon = $point_pos[0];
}elseif($src['latitude']){
    $lat = $src['latitude'];
    $lon = $src['longitude'];
}else{

}





//$lat = 55.77478084;
//$lon = 37.65271604;

//расстояние в километрах для станций ближайших
$distance = 5;

//количество результатов для метро
$results = 5;


$data = file_get_contents("https://api.rasp.yandex.net/v3.0/nearest_stations/?apikey=$api_key&format=json&lat=$lat&lng=$lon&distance=$distance&lang=ru_RU");

$stations = json_decode($data,true)['stations'];

foreach($stations as $station){
    if($station['transport_type'] == 'train'){
        $st = [];
        $st['distance'] = $station['distance'];
        $st['title'] = $station['title'];
        $trainstations[] = $st;
    }
    if($station['transport_type'] == 'bus'){
        $st = [];
        $st['distance'] = $station['distance'];
        $st['title'] = $station['title'];
        $busstops[] = $st;
    }
}

//var_dump($trainstations);
//var_dump($busstops);


if($lat){

//получаем метро рядом
$metros_data = file_get_contents("https://geocode-maps.yandex.ru/1.x/?apikey=$api_key_geo&format=json&geocode=$lon,$lat&kind=metro&results=$results");
$metros = json_decode($metros_data,true)['response'];
$metros_units = $metros['GeoObjectCollection']['featureMember'];

foreach($metros_units as $station){
    $st = [];
    $st['title'] = $station['GeoObject']['name'];
    $points = explode(' ',$station['GeoObject']['Point']['pos']);
    //$st['lat'] = $points[1];
    //$st['lon'] = $points[0];
    $st['distance'] = calculateTheDistance($lat,$lon,$points[1],$points[0])/1000;
    $metrostations[] = $st;
}

//var_dump($metrostations);


?>

    <?if($metrostations || $trainstations  ||$busstops ){?>

        <div class="box-vertical attention isBold">
            Определены ближайшие транспортные узлы
        </div>

        <?$arr = [
                'Станции метро:'=>$metrostations,
                'Ж/Д ост.'=>$trainstations,
                'Автобусные ост.'=>$busstops,
        ]?>

        <?foreach ($arr as $key=>$value){?>
            <?if($value){?>
                <div class="flex-box">
                    <div class="ghost" style="width: 100px;">
                        <?=$key?>
                    </div>
                    <div class="flex-box">
                        <?for($i=0;$i < 3; $i++){?>
                            <div class="box-wide">
                            <span class="isBold">
                                <?=str_replace('метро','',$value[$i]['title'])?>
                            </span>
                                <span class="ghost">
                                (<?=round($value[$i]['distance'],2)?>км)
                            </span>
                            </div>
                        <?}?>
                    </div>
                </div>
            <?}?>
        <?}?>

    <?}?>

<?}?>
<?

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$address = urlencode('Россия, Москва, Кремль');

$url = 'https://geocode-maps.yandex.ru/1.x/?apikey=7cb3c3f6-2764-4ca3-ba87-121bd8921a4e&format=json&geocode='.$address;


if( $curl = curl_init() ) {
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
    $out = curl_exec($curl);
    //echo $out;
    curl_close($curl);
}

$data = json_decode($out);

$point = explode(' ',$data->response->GeoObjectCollection->featureMember[0]->GeoObject->Point->pos);
//var_dump($point);

echo json_encode($point);

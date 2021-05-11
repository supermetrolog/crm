<?php



ini_set('error_reporting', E_ALL);ini_set('display_errors', 1);ini_set('display_startup_errors', 1);
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');


$table = 'c_industry';

$no_address = [];

$sql = $pdo->prepare("SELECT * FROM $table WHERE deleted!='1' LIMIT 10");
$sql->execute();
while($item = $sql->fetch(PDO::FETCH_LAZY)){

    $url = 'https://geocode-maps.yandex.ru/1.x/?apikey=2b6763cf-cc99-48c7-81f1-f4ceb162502a&format=json&geocode='.urlencode($item->address);


    if( $curl = curl_init() ) {
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $out = curl_exec($curl);
        //echo $out;
        curl_close($curl);
    }

    $data = json_decode($out);


    if($data->response->GeoObjectCollection->featureMember[0] && !$data->response->GeoObjectCollection->featureMember[1]){
        //echo 'все ок';
    }else{
        $no_address[] = $item->id;
    }


}

$line  = implode(',',$no_address);

file_put_contents('has_no_address.txt',$line);
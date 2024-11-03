fdfdf
<?php
//for($i = 0; $i < 2; $i++){
/*
    $ch = curl_init("https://metro.yandex.ru/api/get-stations?id=1&lang=ru");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
$data = json_decode($data);
//var_dump($data->data);
*/
$i = 0;
$sql1 = $pdo->prepare("SELECT * FROM c_metros");
$sql1->execute();
while($item = $sql1->fetch(PDO::FETCH_LAZY)){
    $y_id = $item->id;
    $title = $item->title;
    $sql = $pdo->prepare("UPDATE metros SET yandex_id='$y_id' WHERE title LIKE '%$title%'");
    if($sql->execute()){
        echo 1;
        $i++;
    }
}
echo $i;

/*
foreach($data->data as $data_item){
    //var_dump($data_item);
    $sql = $pdo->prepare("INSERT INTO c_metros(id,title)VALUES($data_item->id,'$data_item->name')");
    $sql->execute();
    echo $data_item->id;
    echo '=';
    echo $data_item->name;

    echo '<br>';
}
*/






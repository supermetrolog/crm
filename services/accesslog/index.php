<?php


//смотрим что уже есть в файлах
$data = json_decode(file_get_contents('current.json'),true);

foreach ($data as $visit) {
    echo $visit['ip'] . ' - ' . date("d-m-Y H:m:s",$visit['time']) . '<br>';
}

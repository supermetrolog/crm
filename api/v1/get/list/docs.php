


<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$post = new OfferMix();
$arr = $post->getTableColumnsFullInfo();
//var_dump($arr);

echo "<b>поля каталога</b><br><br>";

foreach ($arr as $item) {
    echo '<div style="width: 200px; display: inline-block;">'.$item['COLUMN_NAME'] . '</div>' . ' - '  . $item['COLUMN_COMMENT'];
    echo '<br>';
}  


   //ini_set('display_errors', 1); ini_set('display_startup_errors', 1); ini_set('error_reporting', E_ALL);


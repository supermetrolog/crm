<?php



date_default_timezone_set("Europe/Moscow");

//$root = '/var/www/www-root/data/www/pennylane.pro';
//$host = 'https://pennylane.pro/';

$root = "/home/user/web/pennylane.pro/public_html";
$host = 'https://pennylane.pro/';

include_once($root . '/global_pass.php');

$sql = $pdo->prepare("SELECT * FROM core_plans WHERE deleted !=1 AND activity=1");
$sql->execute();

//часы ночного времени
//$night_hours = [22, 23, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9];

// Новые часы ночного времени, чтобы фид не генерился с утра.
$night_hours = [22, 23, 0, 1, 2, 3, 4];


while ($task = $sql->fetch(PDO::FETCH_LAZY)) {
    $go_update = 0;
    //если только ночью
    if ($task->at_night) {
        if (in_array(date('G'), $night_hours) && time() > $task->last_update + $task->cooldown) {
            $go_update = 1;
        }
    } else {
        if (time() > $task->last_update + $task->cooldown) {
            $go_update = 1;
        }
    }
    //$go_update = 1;
    //если все ок то обновляем
    
    $logText = date('Y-m-d H:i:s') . " GO_UPDATE: " . $go_update . ", Title: " . $task->title . "\n";
    file_put_contents($root . '/cron.log', $logText, FILE_APPEND);
    
    if ($go_update) {
        $link = $host . $task->link;
        $url = $link;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //для возврата результата в виде строки, вместо прямого вывода в браузер
        $returned = curl_exec($ch);
        curl_close($ch);
        $plan = new \Bitkit\Core\Cron\Plan($task->id);
        $plan->updateField('last_update', time());
        $logText = date('Y-m-d H:i:s') . ": " . $task->title . "\n";
        file_put_contents($root . '/cron.log', $logText, FILE_APPEND);
    }
    //echo $returned;
}


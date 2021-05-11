#!/usr/bin/env php
<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

require_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

$url = 'https://fcm.googleapis.com/fcm/send';
$YOUR_API_KEY = 'AAAA8_fTgnM:APA91bHXVooiL9ffhlLa-17IDeEBkovOP7zgVTi3OsdHYxTX6S04SR-mJsvWgFje5JnA18XZFsjhOZMfBwXfizbE6YbJIoE95hrrUT3aWm_QQs_GdtM0cx6ow41wjJTUOB3RZ-7k_raB'; // Server key
//$YOUR_TOKEN_ID = 'cwqixTXzm5Y:APA91bG2And0eyCw2Bb_9wzERtqi3jHJA5ou-oJABjVfU4p0X_WQSZuJFPCBXQdtBp3SlBmxuqGTu__shYApC77KSMzNsqPi_BKABuURIZQGRHE6SGlx3meZMEU74zQj0mAm2LloDHBP'; // Client token id


$pushes = (new CloudPush())->getAllUnitsId();

foreach($pushes as $id){
    $push = new CloudPush($id);
    $client_token = $push->getField('token');

    echo $client_token;

    $request_body = [
        'to' => $client_token,
        'notification' => [
            'title' => 'Ералаш',
            'body' => sprintf('Начало в %s.', date('H:i')),
            'icon' => 'https://eralash.ru.rsz.io/sites/all/themes/eralash_v5/logo.png?width=192&height=192',
            'click_action' => 'http://eralash.ru/',
        ],
    ];
    $fields = json_encode($request_body);

    $request_headers = [
        'Content-Type: application/json',
        'Authorization: key=' . $YOUR_API_KEY,
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $response = curl_exec($ch);
    curl_close($ch);

    echo $response;
    echo '<br>';


}


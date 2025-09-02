<?php

include_once($_SERVER['DOCUMENT_ROOT'] . '/global_pass.php');

//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

$search = mb_strtolower($_POST['search']);

// $url = 'https://api.pennylane.pro/companies?expand=requests,contacts.emails,contacts.phones,contacts.contactComments,broker,companyGroup,consultant,consultant.userProfile,productRanges,categories,files&all=' . $search;
$url = 'https://api.raysen.ru/companies?fields=id,full_name,nameRu,nameEng&all=' . $search;
$dataJson = file_get_contents($url);

$data = json_decode($dataJson, true);

$response = [];

foreach ($data as $item) {
    $company = [];
    $company[0] = $item['id'];
    if (isset($item['full_name']) && $item['full_name']) {
        $company[1] = $item['full_name'];
    } elseif ($item['nameEng'] || $item['nameRu']) {
        $company[1] = $item['nameRu'] . ' / ' . $item['nameEng'];
    } else {
        $company[1] = $item['id'];
    }
    $response[] = $company;
}


echo json_encode($response, JSON_UNESCAPED_UNICODE);

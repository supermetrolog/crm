<?php


ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

function getApiCompanies() : array
{
    $baseUrl = 'https://https://api.pennylane.pro';
    $xml = file_get_contents($baseUrl . '/companies?expand=requests,contacts.emails,contacts.phones,contacts.contactComments,broker,companyGroup,consultant,consultant.userProfile,productRanges,categories,files');
    $companies = json_decode($xml,true);

    $companiesAssoc = [];
    foreach ($companies as $company) {
        $companiesAssoc[$company['id']] = $company;
    }
    return $companiesAssoc;
}


var_dump(getApiCompanies());

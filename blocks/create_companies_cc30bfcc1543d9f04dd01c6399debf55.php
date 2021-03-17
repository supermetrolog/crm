<?
/*
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
$starttime = time();



/////////////Создаем комании и проставляем клиентам Id компаний
//Создаем/трункатим таблицу компаний
$sql = $pdo->prepare("TRUNCATE TABLE c_industry_companies");
$sql->execute();

//ДЛЯ ВСЕХ ЛЮДЕЙ ИЗ СПИСКА
$sql = $pdo->prepare("SELECT * FROM c_industry_customers");
$sql->execute();
$i = 1;
while($customer = $sql->fetch(PDO::FETCH_LAZY)){

    $client = new Client($customer->id);

    //СМОТРИМ ЕСТЬ ЛИ КОМПАНИЯ С ТАКИМ НАЗВАНИЕМ
    $company_sql = $pdo->prepare("SELECT * FROM c_industry_companies WHERE title='".$customer->company_name."'");
    $company_sql->execute();
    $company = $company_sql->fetch(PDO::FETCH_LAZY);
    //ЕСЛИ НЕТУ КОМПАНИИ С ТАКИМ НАЗВАНИЕМ ТО СОЗДАЕМ ЕЕ И ПИШЕМ АЙДИ ЕЕ ЭТОМУ ЧЕЛОВЕЧКУ
    if(!$company->id){
        $new_company = new Company(0);
        $fields_array = array(
            'title',
            'company_type',
            'company_activity',
            'publ_time',
            'last_update',
            'agent',
            'site_url',
            'description',
            'address',
            'address_google',
            'address_yandex',
            'company_service_name',
        );
        $pars_array = array(
            $customer->company_name,
            $customer->client_group,
            $customer->activity,
            strtotime($customer->dt_insert),
            strtotime($customer->dt_update_full),
            $customer->agent,
            $customer->site_url,
            $customer->description,
            $customer->address,
            $customer->address,
            $customer->address,
            $customer->company_category,
        );
        $client->updateField('company_id',$new_company->createLine($fields_array,$pars_array));
    }else{ //ИНАЧЕ ПИШЕМ ЕМУ АЙДИ ЭТОЙ ФИРМЫ
        $client->updateField('company_id',$company->id);
    }
    echo '<br>'.$i.' шаг';
    $i++;

}
echo time() - $starttime;


//Проставляем ЗАПРОСАМ id компании
$sql = $pdo->prepare("SELECT * FROM c_industry_requests");
$sql->execute();
while($request = $sql->fetch(PDO::FETCH_LAZY)){

    $request_obj = new Request($request->id);
    $client_obj = new Client($request->client_id);

    $request_obj->updateField('company_id',$client_obj->getField('company_id'));

}



//Проставляем ОБЪЕКТАМ id компании
$sql = $pdo->prepare("SELECT * FROM c_industry");
$sql->execute();
while($building = $sql->fetch(PDO::FETCH_LAZY)){

    $building_obj = new Building($building->id);
    $client_obj = new Client($building->client_id);

    $building_obj->updateField('company_id',$client_obj->getField('company_id'));

}

/*
$sql=$pdo->prepare("SELECT * FROM users");
$sql->execute();
while($user = $sql->fetch(PDO::FETCH_LAZY)){
   if($user->user_password != NULL){
      $id = $user->id;
      $crypt_pass = crypt($user->user_password);
      $sql1=$pdo->prepare("UPDATE users SET password='$crypt_pass' WHERE id='$id'");
      $sql1->execute();
   }
   
}
?>												
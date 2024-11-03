<?php

if($_COOKIE['member_id'] == 141) {

    $logedUser = new Member($_COOKIE['member_id']);
    $start_time = time();


    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    $starttime = time();

    $host_old = '178.250.246.48';
    $user_old = 'pci';
    $password_old = 'pci777devH18p';
    $db_old = 'pcidb';
    $charset_old = 'utf8';
    $dsn_old = "mysql:host=$host_old;dbname=$db_old;charset=$charset_old";
//$dsn = "mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=$db;charset=$charset";
    $opt_old = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        $pdo_old = new \PDO($dsn_old, $user_old, $password_old, $opt_old);
        $pdo_old->exec("set names utf8");
    } catch (PDOException $e) {
        echo 'Подключение не удалось: ' . $e->getMessage();
    }

    ?>

    <?php

    /*
        ///////////////////////////////////////////////ПЕРЕКИДЫВАЕМ КЛИЕНТОВ/////////////////////////////////////
        $fields_arr = [
            //'c_type' => 'contact_group',
            'c_fio' => 'title',
            'c_phones' => 'phone',
            'c_emails' => 'email',
            'id' => 'company_id',
            'c_comments' => 'description',
            'dt_insert' => 'publ_time',
            'dt_update_full' => 'last_update',
            'agent' => 'agent_id',
            'deleted' => 'deleted',
            'result' => 'status'
        ];

        $table_old = 'c_industry_customers';
        $table_new = 'c_industry_contacts';

        $sql_del = $pdo->prepare("TRUNCATE TABLE $table_new");
        $sql_del->execute();

        $sql = $pdo_old->prepare("SELECT * FROM $table_old WHERE deleted!='1' ORDER BY id ASC ");
        $sql->execute();

        while ($item_old = $sql->fetch(PDO::FETCH_LAZY)) {
            $item_new = new Post(0);
            $item_new->getTable($table_new);
            $item_new->createLine([], []);

            foreach ($fields_arr as $key => $value) {
                if (in_array($key, array('dt_insert', 'dt_update_full'))) {
                    $insert_value = strtotime($item_old->$key);
                } else {
                    $insert_value = $item_old->$key;
                }
                $item_new->updateField($value, str_replace("'", '', $insert_value));
            }
        }



        //Из второстепенных
        $fields_arr = [
            //'c_type' => 'contact_group',
            'fio' => 'title',
            'phones' => 'phone',
            'emails' => 'email',
            'clyent_id' => 'company_id',
            'dt_insert' => 'publ_time',
            'dt_update' => 'last_update',
            'agent' => 'agent_id',
            'deleted' => 'deleted',
            'dolzhnost' => 'result'
        ];

        $table_old = 'c_industry_peoples';
        $table_new = 'c_industry_contacts';

        $sql = $pdo_old->prepare("SELECT * FROM $table_old WHERE deleted!='1'  ORDER BY id ASC ");
        $sql->execute();

        while ($item_old = $sql->fetch(PDO::FETCH_LAZY)) {
            $item_new = new Post(0);
            $item_new->getTable($table_new);
            $item_new->createLine([], []);

            foreach ($fields_arr as $key => $value) {
                if (in_array($key, array('dt_insert', 'dt_update'))) {
                    $insert_value = strtotime($item_old->$key);
                }elseif (in_array($key, array('dolzhnost'))) {
                    $insert_value = 1;
                } else {
                    $insert_value = $item_old->$key;
                }
                $item_new->updateField($value, str_replace("'", '', $insert_value));
            }
        }

        //Удаляем пустые контакты
        $sql = $pdo->prepare("UPDATE c_industry_contacts SET deleted='1' WHERE title='' AND phone='' ");
        $sql->execute();


        //Удаляем пустые контакты
        $sql = $pdo->prepare("UPDATE c_industry_contacts SET status='1' WHERE status IS NULL ");
        $sql->execute();

    ////////////////////////////////////////////////СОЗДАЕМ КОМПАНИИ//////////+ПРОСТАВЛЯЕМ НОМЕР КОМПАНИИ ЛЮДЯМ//////////////////////////////////////
        //сохраняем значение обработана или нет

        $sql = $pdo->prepare("SELECT * FROM c_industry_companies");
        $sql->execute();
        $processed_arr =[];
        while ($comp = $sql->fetch(PDO::FETCH_LAZY)) {
            array_push($processed_arr,[$comp->id,$comp->processed]);
        }


        $sql_del = $pdo->prepare("TRUNCATE TABLE c_industry_companies");
        $sql_del->execute();

        $sql = $pdo_old->prepare("SELECT * FROM c_industry_customers WHERE deleted!='1'  ORDER BY id ASC ");
        $sql->execute();

        //ДЛЯ ВСЕХ КОИЕНТОВ ИЗ СТАРОЙ БАЗЫ
        while ($company = $sql->fetch(PDO::FETCH_LAZY)) {

            if ($company->id) {

                //echo "Компания $company->id последний раз обновлялась ". $company->publ_time;
                //echo '<br>';

                $company_new = new Company(0);
                $fields_array = array(
                    'id',
                    'title',
                    'address',
                    'site_url',
                    'agent_id',
                    //'contact_id',

                    'publ_time',
                    'last_update',

                    'status',
                    'description',

                    //'company_type',
                    //'company_activity',
                    //'contact_id',
                    //'company_group',
                    //'company_service_name',
                );
                $pars_array = array(
                    $company->id,
                    ($company->c_company) ? $company->c_company : $company->id,
                    $company->address,
                    $company->c_url,
                    ($company->agent) ? $company->agent : '11',
                    //$company->id,

                    strtotime($company->dt_insert),
                    strtotime($company->dt_update_full),
                    //212121212,
                    //33333333333,
                    $company->result,
                    $company->c_comments,

                    //$company->client_group,
                    //$company->activity,
                    //$company->id,
                    //$company->contact_group,
                    //$company->company_category,
                );
                $new_comp_id = $company_new->createLine($fields_array, $pars_array);
                //echo "Создали новую компанию $new_comp_id <br>";

                $sql_sp = $pdo->prepare("SELECT * FROM c_industry_contacts WHERE company_id='$new_comp_id' LIMIT 1");
                $sql_sp->execute();
                $cont = $sql_sp->fetch(PDO::FETCH_LAZY);
                $comp_new_obj = new Company($new_comp_id);
                $comp_new_obj->updateField('contact_id',$cont->id);

            }
        }



        foreach($processed_arr as $comp){
            $company = new Company($comp[0]);
            $company->updateField('processed',$comp[1]);
        }

        //ОЧИЩАЕМ ГРУППУ КОНТАКТОВ
        $sql_del = $pdo->prepare("UPDATE c_industry_contacts SET contact_group=''");
        $sql_del->execute();


    ////////////////////////////////////////ПЕРЕКИДЫВАЕМ ЗАПРОСЫ ОБЪЕКТОВ/////////////////////////////////////////////////////

        $sql_del = $pdo->prepare("TRUNCATE TABLE c_industry_requests");
        $sql_del->execute();

        $fields_arr = [
            'dt_insert' => 'publ_time',
            'dt_update_full' => 'last_update',
            'clyent_id' => 'company_id',
            'object_type2' => 'purposes',
            'n_regions' => 'regions',
            'n_directions' => 'directions',
            'howfloor' => 'floor',
            'n_directions_obl' => 'directions_obl',
            'n_highways' => 'highways',
            'otmkad_min' => 'from_mkad_min',
            'otmkad_max' => 'from_mkad_max',
            'n_class' => 'object_classes',
            'area_min' => 'area_min',
            'area_max' => 'area_max',
            'power' => 'power',
            'deal_type' => 'deal_type',
            'rent_price' => 'contract_is_signed',
            'agent' => 'agent_id',
            'ceiling_height' => 'ceiling_height_min',
            'infosource' => 'infosource',
            'infosource_ext' => 'infosource_comment',
            'result' => 'request_status',
            'dt_result' => 'dt_result',
            'result_who' => 'result_who',
            'comments' => 'description',
            'deleted' => 'deleted',
            'floor_type' => 'floor_type',
            'gate_type' => 'gate_type',
        ];

        $table_old = 'c_industry_requests';
        $table_new = 'c_industry_requests';

        $sql = $pdo_old->prepare("SELECT * FROM $table_old WHERE deleted!='1' ORDER BY id ASC ");
        $sql->execute();


        while ($item_old = $sql->fetch(PDO::FETCH_LAZY)) {

            $item_new = new Post(0);
            $item_new->getTable($table_new);
            $item_new->createLine(['id'], [$item_old->id]);

            foreach ($fields_arr as $key => $value) {
                //чтобы изменить запятые на JSON
                if (in_array($key, array('object_type2', 'n_regions', 'n_directions', 'n_directions_obl', 'n_highways', 'n_class'))) {
                    $val_arr = explode(',', trim($item_old->$key, ','));
                    $val_arr_new = [];
                    if($key == 'n_highways'){
                        $tbl_old = 'l_highways';
                        $tbl_new = 'l_highways';
                    }elseif($key == 'n_directions'){
                        $tbl_old = 'l_directions';
                        $tbl_new = 'l_directions';
                    }else{
                        $tbl_old = 'l_regions';
                        $tbl_new = 'l_regions';
                    }
                    //смотрим старые назания и ищем их в новых таблицах
                    foreach($val_arr as $val_item){
                        $sql_1 = $pdo_old->prepare("SELECT * FROM $tbl_old WHERE  id='$val_item' ");
                        $sql_1->execute();
                        $item_info = $sql_1->fetch(PDO::FETCH_LAZY);
                        $item_name = mb_strtolower(trim($item_info->title));
                        echo $item_name.'<br>';
                        $sql_2 = $pdo->prepare("SELECT * FROM $tbl_new WHERE title='$item_name' ");
                        $sql_2->execute();
                        $new_item_info = $sql_2->fetch(PDO::FETCH_LAZY);
                        //echo $new_item_info->id;
                        if($new_item_info->id){
                            array_push($val_arr_new,$new_item_info->id);
                        }
                    }
                    $insert_value = json_encode($val_arr_new);
                    //CREATING A OBJECT_TYPE FROM A PURPOSES
                    if ($key == 'object_type2' && count(array_uintersect(['2', '4', '5', '6'], $val_arr, "strcasecmp"))) {
                        $item_new->updateField('object_type', 2);
                        //echo 'Мы нашли запрос у которого назначения под производство.его номер' . $item_old->id . ' <br>';
                        //var_dump(array_uintersect(['2', '4', '5', '6'], $val_arr, "strcasecmp"));
                        //echo 'Пересечений в объекте =' . count(array_uintersect(['2', '4', '5', '6'], $val_arr, "strcasecmp"));
                        //echo '<br>';
                    } elseif ($key == 'object_type2') {
                        $item_new->updateField('object_type', 1);
                    } else {

                    }
                }elseif($key == 'result'){
                    if($item_old->$key == '0'){
                        $insert_value = 6;
                    }else{
                        $insert_value = $item_old->$key;
                    }
                }elseif($key == 'rent_price'){
                    if($item_old->deal_type == '1'){
                        if($item_old->rent_price){
                            $item_new->updateField('price', $item_old->rent_price);
                        }
                        if($item_old->rent_price_max){
                            $item_new->updateField('price', $item_old->rent_price_max);
                        }
                        //$item_new->updateField('price_min', $item_old->rent_price);
                        //$item_new->updateField('price_max', $item_old->rent_price_max);
                    }elseif($item_old->deal_type == '2'){
                        if($item_old->sale_price){
                            $item_new->updateField('price', $item_old->sale_price);
                        }
                        if($item_old->sale_price_max){
                            $item_new->updateField('price', $item_old->sale_price_max);
                        }
                        //$item_new->updateField('price_min', $item_old->sale_price);
                        //$item_new->updateField('price_max', $item_old->sale_price_max);
                    }else{

                    }
                }elseif (in_array($key, array('dt_insert', 'dt_update_full',))) {
                    $insert_value = strtotime($item_old->$key);
                } else {
                    $insert_value = $item_old->$key;
                }
                $item_new->updateField($value, $insert_value);
            }
        }


    ////////////////////////////////////////ПЕРЕКИДЫВАЕМ ЗАПРОСЫ ЗЕМЛИ/////////////////////////////////////////////////////
        $fields_arr = [
            'dt_insert' => 'publ_time',
            'dt_update_full' => 'last_update',
            'clyent_id' => 'company_id',
            'n_regions' => 'regions',
            'n_directions' => 'directions',
            'n_highways' => 'highways',
            'otmkad_min' => 'from_mkad_min',
            'otmkad_max' => 'from_mkad_max',
            'area_min' => 'area_min',
            'area_max' => 'area_max',
            'deal_type' => 'deal_type',
            'budget_f' => 'contract_is_signed',
            'agent' => 'agent_id',
            'result' => 'request_status',
            'comments' => 'description',
            'deleted' => 'deleted'
        ];

        $table_old = ' c_industry_lands_requests';
        $table_new = 'c_industry_requests';

        $sql = $pdo_old->prepare("SELECT * FROM $table_old WHERE deleted!='1' ORDER BY id ASC ");
        $sql->execute();


        while ($item_old = $sql->fetch(PDO::FETCH_LAZY)) {

            //echo 'Перекинули запрос земли номер '.$item_old->id;
            //echo '<br>';
            $item_new = new Post(0);
            $item_new->getTable($table_new);
            //$item_new->createLine(['id'], [$item_old->id]);
            $item_new->createLine(['activity'], ['1']);

            foreach ($fields_arr as $key => $value) {
                //чтобы изменить запятые на JSON
                if (in_array($key, array('n_regions', 'n_directions',  'n_highways'))) {
                    $val_arr = explode(',', trim($item_old->$key, ','));
                    $val_arr_new = [];
                    if($key == 'n_highways'){
                        $tbl_old = 'l_highways';
                        $tbl_new = 'l_highways';
                    }elseif($key == 'n_directions'){
                        $tbl_old = 'l_directions';
                        $tbl_new = 'l_directions';
                    }else{
                        $tbl_old = 'l_regions';
                        $tbl_new = 'l_regions';
                    }
                    //смотрим старые назания и ищем их в новых таблицах
                    foreach($val_arr as $val_item){
                        $sql_1 = $pdo_old->prepare("SELECT * FROM $tbl_old WHERE  id='$val_item' ");
                        $sql_1->execute();
                        $item_info = $sql_1->fetch(PDO::FETCH_LAZY);
                        $item_name = mb_strtolower(trim($item_info->title));
                        //echo $item_name.'<br>';
                        $sql_2 = $pdo->prepare("SELECT * FROM $tbl_new WHERE title='$item_name' ");
                        $sql_2->execute();
                        $new_item_info = $sql_2->fetch(PDO::FETCH_LAZY);
                        //echo $new_item_info->id;
                        if($new_item_info->id){
                            array_push($val_arr_new,$new_item_info->id);
                        }
                    }
                    $insert_value = json_encode($val_arr_new);
                }elseif (in_array($key, array('dt_insert', 'dt_update_full'))) {
                    $insert_value = strtotime($item_old->$key);
                }elseif($key == 'result'){
                    if($item_old->$key == '0'){
                        $insert_value = 6;
                    }else{
                        $insert_value = $item_old->$key;
                    }
                }elseif($key == 'budget_f'){
                    if($item_old->deal_type == '1'){
                        $item_new->updateField('price', $item_old->budget_f/100);
                    }elseif($item_old->deal_type == '2'){
                        $item_new->updateField('price', $item_old->budget_f/100);
                    }else{

                    }
                } else {
                    $insert_value = $item_old->$key;
                }
                $item_new->updateField($value, $insert_value);
            }
        }






    ///////////////СОЗДАЕМ СДЕЛКИ/////////////////////////////////////
        /// задаем таблицы сделок и запросов
        $table_new = 'c_industry_deals';
        $table_old = 'c_industry_requests';

        //очищаем таблицу сделаок
        $sql_del = $pdo->prepare("TRUNCATE TABLE $table_new");
        $sql_del->execute();

        $sql = $pdo->prepare("SELECT * FROM $table_old WHERE deleted!='1' ORDER BY id ASC ");
        $sql->execute();


        //для каждого запроса из таблицы запросов
        while ($item_old = $sql->fetch(PDO::FETCH_LAZY)) {

            //var_dump($item_old);

            $item_new = new Post(0);
            $item_new->getTable($table_new);

            //echo 'Кароче компании'.$item_old->company_id.'<br>';
            //echo 'Кароче тип сделки'.$item_old->deal_type.'<br>';
            //echo 'Кароче агент ID'.$item_old->agent_id.'<br>';

            //создаем новую сделку
            $new_deal_id = $item_new->createLine(['company_id','deal_type',], [$item_old->company_id,$item_old->deal_type]);

            $item_old = new Post($item_old->id);
            $item_old->getTable($table_old);

            //записываем ID сделки в запрос чтобы установить связь
            $item_old->updateField('deal_id',$new_deal_id);

        }



    */

//<----------ОТСЮДА ОБЪЕКТЫ И БЛОКИ И ПРЕДЛОЖЕНИЯ-------->



//---------ПЕРЕКИДЫВАЕМ ОБЬЕКТЫ


    $sql_del = $pdo->prepare("TRUNCATE TABLE c_industry");
    $sql_del->execute();


/////////////////////////////////////////////////////////////////////////////////////////////////
    $fields_arr = [
        'dt_insert' => 'publ_time',
        'dt_update_full' => 'last_update',
        'clyent_id' => 'company_id',
        'object_class' => 'object_class',
        'object_type2' => 'purposes',
        //'purpose_warehouse' => 'purpose_warehouse',
        //'region' => 'region',
        'deal_type' => 'deal_type_help',
        //'district' => 'district',
        //'direction' => 'direction',
        'railway_station' => 'railway_station',
        //'village' => 'village',
        //'highway' => 'highway',
        'otmkad' => 'from_mkad',
        //'metro' => 'metro',
        'address' => 'address',
        //'yandex_address_str' => 'address',
        'cadastral_number' => 'cadastral_number',
        //'yandex_address_str' => 'address_yandex',
        'u_area' => 'area_field',
        't_area' => 'area_building',
        'openstage' => 'area_outside',
        'o_area' => 'area_office',
        'floors' => 'floors',
        'facing_type' => 'facing_type',
        'year_build' => 'year_build',
        'year_reconst' => 'year_reconst',
        'gas' => 'gas',
        'vape' => 'steam',
        'power_all' => 'power',
        'gas_how' => 'gas_value',
        'vape_how' => 'steam_value',
        'water' => 'water',
        'sewage' => 'sewage',
        'heating' => 'heating',
        'ventilation' => 'ventilation',
        'telephony' => 'phone_line',
        'internet' => 'internet_type',
        'firefighting'=>'firefighting_type',
        'guard' => 'guard',
        'entrance_type' => 'entrance_type',
        'entry_territory' => 'entry_territory',
        'parking_car_type' => 'parking_car_value',
        'parking_truck_type' => 'parking_truck_value',
        'parking_car' => 'parking_car',
        'parking_truck' => 'parking_truck',
        'office_price' => 'price_office',
        'mezz_price' => 'price_mezzanine',
        'result' => 'status_rent',
        'result_sale' => 'status_sale',
        'result_safe' => 'status_safe',
        'result_subrent' => 'status_subrent',
        'incs_currency' => 'tax_form',
        '_calc_rent_payinc' => '_calc_rent_payinc',
        '_calc_safe_payinc' => '_calc_safe_payinc',
        '_calc_sale_payinc' => '_calc_sale_payinc',
        '_calc_subrent_payinc' => '_calc_subrent_payinc',
        'agent' => 'agent_id',
        'agent_sale' => 'agent_sale',
        'agent_safe' => 'agent_safe',
        'agent_subrent' => 'agent_subrent',
        'agent_visited' => 'agent_visited',
        'agent_visited_sale' => 'agent_visited_sale',
        'agent_visited_safe' => 'agent_visited_safe',
        'agent_visited_subrent' => 'agent_visited_subrent',
        'c_x' => 'longitude',
        'c_y' => 'latitude',
        'deleted' => 'deleted',
        'prepay' => 'deposit',
        'deposit' => 'pledge',
        'dt_dogovor' => 'contract_date',
        'from_metro' => 'from_metro',
        'from_metro_by' => 'from_metro_by',
        'p_elevators' => 'elevators',
        'gantry_cranes' => 'gantry_cranes',
        'railway' => 'railway',
        'railway_length' => 'railway_value',
        'description' => 'description_auto',
        'description_handmade' => 'description',
        'slcomments' => 'comments',
        'plain_type' => 'own_type',
        'safety_systems'=>'security_system',
        'owner_pays_howmuch'=>'owner_pays_howmuch',
        'owner_pays_howmuch_sale'=>'owner_pays_howmuch_sale',
        'owner_pays_howmuch_safe'=>'owner_pays_howmuch_safe',
        'owner_pays_howmuch_subrent'=>'owner_pays_howmuch_subrent',
        'onsite'=>'onsite',
        'infrastructure'=>'infrastructure',
        'import_sale_cian'=>'import_sale_cian',
        'import_sale_free'=>'import_sale_free',
        'import_sale_yandex'=>'import_sale_yandex',
        'import_rent_cian'=>'import_rent_cian',
        'import_rent_free'=>'import_rent_free',
        'import_rent_yandex'=>'import_rent_yandex',
        'import_sale_cian_premium'=>'import_sale_cian_premium',
        'import_rent_cian_premium'=>'import_rent_cian_premium',
        'import_sale_cian_top3'=>'import_sale_cian_top3',
        'import_rent_cian_top3'=>'import_rent_cian_top3',
        'import_sale_cian_hl'=>'import_sale_cian_hl',
        'import_rent_cian_hl'=>'import_rent_cian_hl'

    ];


    $table_old = 'c_industry';
    $table_new = 'c_industry';


    $obj_arr = [];

    $sql = $pdo_old->prepare("SELECT * FROM $table_old WHERE deleted!='1' ORDER BY id ASC ");
    $sql->execute();

    while ($item_old = $sql->fetch(PDO::FETCH_LAZY)) {
        $item_new = new Post(0);
        $item_new->getTable($table_new);
        $item_new->createLine(['id'], [$item_old->id]);

        $obj_arr[] = $item_old->id;

        foreach ($fields_arr as $key => $value) {
            //чтобы изменить запятые на JSON
            if (in_array($key, ['object_type2'])) {
                $purp_arr_main = explode(',', trim($item_old->$key, ','));

                $purp_arr = explode(',', trim($item_old->purpose_warehouse, ','));
                //echo 'Объект номер ' . $item_old->id;
                //echo '<br>';
                //var_dump($purp_arr);
                //echo '<br>';
                foreach($purp_arr as $key2=>$value2){
                    if($value2 == 1){
                        $purp_arr[$key2] = '10';
                    }elseif($value2 == 2){
                        $purp_arr[$key2] = '11';
                    }elseif($value2 == 3){
                        $purp_arr[$key2] = '12';
                    }else{

                    }
                }
                //var_dump($purp_arr);
                // echo '<br>';
                //var_dump($purp_arr_main);
                //echo '<br><br>';
                if(arrayIsNotEmpty($purp_arr)){
                    $result = array_merge($purp_arr_main,$purp_arr);
                }else{
                    $result = $purp_arr_main;
                }
                //var_dump($result);
                //echo '<br><br>';
                $insert_value = json_encode($result);
            }elseif(in_array($key, ['prepay','deposit'])){
                if($key == 'prepay' &&  $item_old->$key > 0){
                    $insert_value = $item_old->$key;
                }
                if($key == 'deposit' &&  $item_old->$key > 0 ){
                    $insert_value = $item_old->$key;
                }
                $insert_value = $item_old->$key;
                if($insert_value < 0){
                    $insert_value = 0;
                }
            }elseif(in_array($key, ['incs_currency'])){
                if($item_old->deal_type == '3' ){       //Аренда
                    $insert_value = explode(',',trim($item_old->incs_currency_safe,','))[0];
                }else{
                    $insert_value = explode(',',trim($item_old->incs_currency,','))[0];
                }

            }elseif(in_array($key, ['address'])){
                if($item_old->address){
                    $insert_value = $item_old->address;
                }
                if($item_old->yandex_address_str){
                    $insert_value = $item_old->yandex_address_str;
                }
            }elseif(in_array($key, ['infrastructure'])){
                $infra_arr =  explode(',', trim($item_old->$key, ','));
                if(in_array(1,$infra_arr)){
                    $item_new->updateField('hostel', 1);
                }
                if(in_array(2,$infra_arr)){
                    $item_new->updateField('canteen', 1);
                }

            }elseif(in_array($key, ['safety_systems'])){
                $insert_arr = explode(',',trim($item_old->safety_systems,','));
                foreach($insert_arr as $item){
                    if($item == '1'){
                        $item_new->updateField('video_control', 1);
                    }elseif($item == '2'){
                        $item_new->updateField('access_control', 1);
                    }elseif($item == '3'){
                        $item_new->updateField('security_alert', 1);
                    }elseif($item == '4'){
                        $item_new->updateField('fire_alert', 1);
                    }elseif($item == '7'){
                        $item_new->updateField('smoke_exhaust', 1);
                    }else{

                    }
                }
            }elseif($key == 'dt_update_full' || $key == 'dt_insert'){
                $insert_value = strtotime($item_old->$key);
            }elseif($key == 'sewage'){
                if($item_old->sewage == '2'){
                    $item_new->updateField('sewage_central', 1);
                }elseif($item_old->sewage == '1'){
                    $item_new->updateField('access_rain', 1);
                }else{

                }
            }else{
                if($key == 'u_area'){
                    $insert_value = $item_old->$key*100;
                }else{
                    $insert_value = $item_old->$key;
                }

            }
            $item_new->updateField($value, $insert_value);
        }
    }


    ///////////////--------------ПЕРЕКИДЫВАЕМ БЛОКИ
    ///////////////////////////////////////////////////////////////////////////////////////////////
    $fields_arr = [

        'id_visual' => 'id_visual',
        'parent_id' => 'object_id',
        'area' => 'area_min',
        'area2' => 'area_max',
        'pallet_mest' => 'pallet_place_min',
        'pallet_mest2' => 'pallet_place_max',
        'area_mezz' => 'area_mezzanine',
        'area_office' => 'area_office',
        'floor' => 'floor',
        'floor_type' => 'floor_type',
        'floor_level' => 'floor_level',
        'ceiling_height' => 'ceiling_height_min',
        'ceiling_height2' => 'ceiling_height_max',
        'temp' => 'temperature_max',
        'power' => 'power',
        'rent_price' => 'price',
        'sale_price' => 'price_sale',
        'safe_price_rack' => 'price_safe_rack',
        'mezz_price' => 'price_mezzanine',
        'office_price' => 'price_office',
        'description_handmade' => 'description',
        'description' => 'description_auto',
        'description_handmade_use' => 'description_manual_use',
        'dt_insert' => 'publ_time',
        'dt_update_full' => 'last_update',
        'deleted' => 'deleted',
        'photos' => 'photos',
        'deal_type' => 'deal_type',
        'heated' => 'heated',
        'collon_mesh' => 'column_grid',
        'floor_load' => 'load_floor',
        'mezz_load' => 'load_mezzanine',
        'gates_number' => 'gates',
        'gate_type' => 'gate_type',
        'warehouse_equipment' => 'warehouse_equipment',
        'finishing' => 'finishing',
        'import_cian' => 'ad_cian',
        'import_cian_hl' => 'ad_cian_hl',
        'import_cian_top3' => 'ad_cian_top3',
        'import_cian_premium' => 'ad_cian_premium',
        'import_yandex' => 'ad_yandex',
        'import_yandex_raise' => 'ad_yandex_raise',
        'import_yandex_promotion' => 'ad_yandex_promotion',
        'import_yandex_premium' => 'ad_yandex_premium',
        'import_free'=>'ad_free',
        'telphers' => 'telphers',
        'catheads' => 'cranes_cathead',
        'overhead_cranes' => 'cranes_overhead',
        's_elevators' => 'elevators',
        'result' => 'status',
        'payinc' => 'payinc',
        'payinc_opex' => 'payinc_opex',
        'payinc_heat' => 'payinc_heating',
        'payinc_water' => 'payinc_water',
        'payinc_e' => 'payinc_electricity',
        'onsite_noprice' => 'hide_site_price',

    ];


    $table_old = 'c_industry_blocks';
    $table_new = 'c_industry_blocks';

    $allowed_objects = implode(',',$obj_arr);

    $sql_del = $pdo->prepare("TRUNCATE TABLE $table_new");
    $sql_del->execute();

    $sql = $pdo_old->prepare("SELECT * FROM $table_old WHERE deleted!='1' AND parent_id IN($allowed_objects) ORDER BY id ASC  ");
    $sql->execute();



    while ($item_old = $sql->fetch(PDO::FETCH_LAZY)) {
        $item_new = new Post(0);
        $item_new->getTable($table_new);
        $item_new->createLine(['id'], [$item_old->id]);

        foreach ($fields_arr as $key => $value) {
            if (in_array($key, ['telphers','catheads','overhead_cranes','s_elevators'])) {
                $insert_value = json_encode(explode(',', trim($item_old->$key, ',')));
            }elseif($key == 'dt_update_full' || $key == 'dt_insert'){
                $insert_value = strtotime($item_old->$key);
            }elseif(in_array($key, ['result'])){
                if($item_old->$key == 5){
                    $insert_value = 1;
                }else{
                    $insert_value = 2;
                }
                $item_new->updateField('status_id', $item_old->result);
            }else{
                if($key == 'gates_number'){
                    if((int)$item_old->gate_type){
                        if((int)$item_old->gates_number){
                            $insert_value = json_encode([(int)$item_old->gate_type,(int)$item_old->gates_number]);
                        }else{
                            $insert_value = json_encode([(int)$item_old->gate_type,0]);
                        }
                    }
                }elseif($key == 'price_safe_rack'){
                    $item_new->updateField('price_safe_rack_min', $item_old->price_safe_rack);
                    $item_new->updateField('price_safe_rack_max', $item_old->price_safe_rack);
                    $insert_value = $item_old->$key;
                }elseif($key == 'dt_update_full' || $key == 'dt_insert'){
                    $insert_value = strtotime($item_old->$key);
                }else{
                    $insert_value = $item_old->$key;
                }
            }
            $item_new->updateField($value, $insert_value);
        }
        //Проставляем основную цену блока

        //echo $item_new->postId();
        $building = new Building($item_new->postId());
        $deal_type = $item_old->deal_type;
        if($deal_type == 2){ //продажа
            $price = $item_old->sale_price;
        }elseif($deal_type == 3){ //3 ответ хранение
            $price = $item_old->safe_price_rack;
        }else{
            $price = $item_old->rent_price;
        }
    }

    $sql = $pdo->prepare("UPDATE c_industry_blocks SET ad_realtor='1' WHERE ad_cian='1' ");
    $sql->execute();



    //создаем БЛОКИ для ОТВ ХРАНЕНИЯ
/////////////////////////////////////////////////////////////////////////////////////////////////
    $fields_arr = [
        'dt_insert' => 'publ_time',
        'dt_update_full' => 'last_update',
        'clyent_id' => 'company_id',
        'object_class' => 'object_class',
        'object_type2' => 'purposes',
        //'region' => 'region',
        'deal_type' => 'deal_type_help',
        //'district' => 'district',
        //'direction' => 'direction',
        'railway_station' => 'railway_station',
        //'village' => 'village',
        //'highway' => 'highway',
        'otmkad' => 'from_mkad',
        //'metro' => 'metro',
        'address' => 'address',
        //'yandex_address_str' => 'address',
        'cadastral_number' => 'cadastral_number',
        //'yandex_address_str' => 'address_yandex',
        'u_area' => 'area_field',
        't_area' => 'area_building',
        'openstage' => 'area_outside',
        'o_area' => 'area_office',
        'floors' => 'floors',
        'facing_type' => 'facing_type',
        'year_build' => 'year_build',
        'year_reconst' => 'year_reconst',
        'gas' => 'gas',
        'vape' => 'steam',
        'power_all' => 'power',
        'gas_how' => 'gas_value',
        'vape_how' => 'steam_value',
        'water' => 'water',
        'sewage' => 'sewage',
        'heating' => 'heating',
        'ventilation' => 'ventilation',
        'telephony' => 'phone_line',
        'internet' => 'internet_type',
        'firefighting'=>'firefighting_type',
        'guard' => 'guard',
        'entrance_type' => 'entrance_type',
        'entry_territory' => 'entry_territory',
        'parking_car_type' => 'parking_car_value',
        'parking_truck_type' => 'parking_truck_value',
        'parking_car' => 'parking_car',
        'parking_truck' => 'parking_truck',
        'office_price' => 'price_office',
        'mezz_price' => 'price_mezzanine',
        'result' => 'status_rent',
        'result_sale' => 'status_sale',
        'result_safe' => 'status_safe',
        'result_subrent' => 'status_subrent',
        'incs_currency' => 'tax_form',
        '_calc_rent_payinc' => '_calc_rent_payinc',
        '_calc_safe_payinc' => '_calc_safe_payinc',
        '_calc_sale_payinc' => '_calc_sale_payinc',
        '_calc_subrent_payinc' => '_calc_subrent_payinc',
        'agent' => 'agent_id',
        'agent_sale' => 'agent_sale',
        'agent_safe' => 'agent_safe',
        'agent_subrent' => 'agent_subrent',
        'agent_visited' => 'agent_visited',
        'agent_visited_sale' => 'agent_visited_sale',
        'agent_visited_safe' => 'agent_visited_safe',
        'agent_visited_subrent' => 'agent_visited_subrent',
        'c_x' => 'longitude',
        'c_y' => 'latitude',
        'deleted' => 'deleted',
        'prepay' => 'deposit',
        'deposit' => 'pledge',
        'dt_dogovor' => 'contract_date',
        'from_metro' => 'from_metro',
        'from_metro_by' => 'from_metro_by',
        'p_elevators' => 'elevators',
        'gantry_cranes' => 'gantry_cranes',
        'railway' => 'railway',
        'railway_length' => 'railway_value',
        'description' => 'description_auto',
        'description_handmade' => 'description',
        'slcomments' => 'comments',
        'plain_type' => 'own_type',
        'safety_systems'=>'security_system',
        'owner_pays_howmuch'=>'owner_pays_howmuch',
        'owner_pays_howmuch_sale'=>'owner_pays_howmuch_sale',
        'owner_pays_howmuch_safe'=>'owner_pays_howmuch_safe',
        'owner_pays_howmuch_subrent'=>'owner_pays_howmuch_subrent',
        'onsite'=>'onsite',
        'infrastructure'=>'infrastructure',
        'import_sale_cian'=>'import_sale_cian',
        'import_sale_free'=>'import_sale_free',
        'import_sale_yandex'=>'import_sale_yandex',
        'import_rent_cian'=>'import_rent_cian',
        'import_rent_free'=>'import_rent_free',
        'import_rent_yandex'=>'import_rent_yandex',
        'import_sale_cian_premium'=>'import_sale_cian_premium',
        'import_rent_cian_premium'=>'import_rent_cian_premium',
        'import_sale_cian_top3'=>'import_sale_cian_top3',
        'import_rent_cian_top3'=>'import_rent_cian_top3',
        'import_sale_cian_hl'=>'import_sale_cian_hl',
        'import_rent_cian_hl'=>'import_rent_cian_hl'
    ];


    $table_old = 'c_industry';

    $sql = $pdo_old->prepare("SELECT * FROM $table_old  WHERE deleted!='1' AND  deal_type LIKE '%3%'ORDER BY id ASC ");
    $sql->execute();

    while ($item_old = $sql->fetch(PDO::FETCH_LAZY)) {

        $subitem_new = new Subitem(0);

        if($item_old->result == 5  || $item_old->result == NULL ){
            $status = 1;
        }else{
            $status = 2;
        }

        $keys_arr = [];
        $values_arr = [];

        array_push($keys_arr,'pallet_place_min');
        array_push($values_arr,$item_old->area_min_safe);

        array_push($keys_arr,'pallet_place_max');
        array_push($values_arr,$item_old->area_max_safe);

        array_push($keys_arr,'price_safe_rack');
        array_push($values_arr,$item_old->rent_price_safe);

        array_push($keys_arr,'status');
        array_push($values_arr,$status);

        array_push($keys_arr,'publ_time');
        array_push($values_arr,strtotime($item_old->dt_insert));

        array_push($keys_arr,'last_update');
        array_push($values_arr,strtotime($item_old->dt_update_full));

        array_push($keys_arr,'object_id');
        array_push($values_arr,$item_old->id);

        array_push($keys_arr,'deal_type');
        array_push($values_arr,3);

        $safe_block_id = $subitem_new->createLine($keys_arr, $values_arr);

        echo "СОЗДАЛ блок по ответке номер его $safe_block_id <br>";
    }



//---------ПЕРЕКИДЫВАЕМ ЗЕМЛЮ   + создаем блоки земли
/////////////////////////////////////////////////////////////////////////////////////////////////
    $fields_arr = [
        'dt_insert' => 'publ_time',
        'dt_update_full' => 'last_update',
        'clyent_id' => 'company_id',
        'type' => 'purposes',
        'deal_type' => 'deal_type_help',
        'otmkad' => 'from_mkad',
        'address' => 'address',
        'cnumber' => 'cadastral_number',
        'u_area' => 'area_field',
        'gas' => 'gas',
        'water' => 'water',
        'sewage' => 'sewage',
        'barrier' => 'barrier',
        'guard' => 'guard',
        'result' => 'status',
        'agent' => 'agent_id',
        'sale_price'=>'sale_price',
        'rent_price'=>'rent_price',
        'c_x' => 'longitude',
        'c_y' => 'latitude',
        'deleted' => 'deleted',
        'gantry_cranes' => 'gantry_cranes',
        'railway' => 'railway',
        'description' => 'description',
        'slcomments' => 'comments',
        'l_property' => 'own_type_land',
        'l_category' => 'land_category',
        'cover_type' => 'floor_type',
        'safety_systems'=>'security_system',
        'onsite'=>'onsite',
        'owner_pays_howmuch'=>'owner_pays_howmuch'
    ];


    $table_old = 'c_industry_lands';
    $table_new = 'c_industry';

    $sql = $pdo_old->prepare("SELECT * FROM $table_old WHERE deleted!='1' ORDER BY id ASC ");
    $sql->execute();

    while ($item_old = $sql->fetch(PDO::FETCH_LAZY)) {
        $item_new = new Post(0);
        $item_new->getTable($table_new);
        $item_new->createLine(['id','is_land'], [$item_old->id,1]);

        if($item_old->result == 0 ){
            $status = 1;
        }else{
            $status = 2;
        }

        if($item_old->sale_price_metr){
            $price_sale = $item_old->sale_price_metr;
        }else{
            $price_sale = $item_old->sale_price/$item_old->u_area;
        }

        if($item_old->deal_type == 0){
            if($item_old->type == '1'){
                $deal_types = 1;
            }else{
                $deal_types = 2;
            }
        }else{
            $deal_types = trim(trim($item_old->deal_type),',');
        }

        $deals = explode(',',$deal_types);

        foreach($deals as $deal){
            $block_new = new Subitem(0);
            $block_new->createLine(['object_id','id_visual','deal_type','publ_time','last_update','price','price_sale','price_office','area_min','area_max','status','is_land'],
                [$item_old->id,1,$deal,strtotime($item_old->dt_insert),strtotime($item_old->dt_update_full),$item_old->rent_price,$price_sale,$item_old->office_price,$item_old->u_area,$item_old->u_area,$status,1]);
        }



        foreach ($fields_arr as $key => $value) {
            //чтобы изменить запятые на JSON
            if($key == 'type'){
                if($item_old->type == '1'){
                    $insert_value = json_encode(['15']);
                }elseif($item_old->type == '2'){
                    $insert_value = json_encode(['13']);
                }else{

                }
            }elseif($key == 'sewage'){
                if($item_old->sewage == '2'){
                    $item_new->updateField('sewage_central', 1);
                }elseif($item_old->sewage == '1'){
                    $item_new->updateField('access_rain', 1);
                }else{

                }
            }elseif(in_array($key, ['incs_currency'])){
                if($item_old->deal_type == '3' ){       //Аренда
                    $insert_value = explode(',',trim($item_old->incs_currency_safe,','))[0];
                }else{
                    $insert_value = explode(',',trim($item_old->incs_currency,','))[0];
                }

            }elseif(in_array($key, ['safety_systems'])){
                $insert_arr = explode(',',trim($item_old->safety_systems,','));
                foreach($insert_arr as $item){
                    if($item == '1'){
                        $item_new->updateField('video_control', 1);
                    }elseif($item == '2'){
                        $item_new->updateField('access_control', 1);
                    }elseif($item == '3'){
                        $item_new->updateField('security_alert', 1);
                    }elseif($item == '4'){
                        $item_new->updateField('fire_alert', 1);
                    }elseif($item == '7'){
                        $item_new->updateField('smoke_exhaust', 1);
                    }else{

                    }
                }
            }elseif(in_array($key, ['result'])){
                $insert_value = 1;
                $item_new->updateField('result_rent', $item_old->result);
                $item_new->updateField('result_sale', $item_old->result);
                $item_new->updateField('result_safe', $item_old->result);
                $item_new->updateField('result_subrent', $item_old->result);
            }elseif($key == 'dt_update_full' || $key == 'dt_insert'){
                $insert_value = strtotime($item_old->$key);
            }else{
                $insert_value = $item_old->$key;
            }
            $item_new->updateField($value, $insert_value);
        }
    }


    //проставляем фотографии в объекты  из файлов
    //echo '<------------------------!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!----------------------------------------->';
    $sql = $pdo->prepare("SELECT * FROM c_industry WHERE deleted!='1' ORDER BY id ASC");
    $sql->execute();

    while ($item_new = $sql->fetch(PDO::FETCH_LAZY)) {
        $id = $item_new->id;
        $item_new = new Post($id);
        $item_new->getTable('c_industry');
        $files = array_diff( scandir($_SERVER['DOCUMENT_ROOT']."/uploads/objects/$id/"), ['..', '.']); //иначе scandir() дает точки
        $files_list = [];
        foreach ($files as $file){
            array_push($files_list,"/uploads/objects/$id/$file");
        }
        $item_new->updateField('photo', json_encode($files_list));
        //СОЗДАНИЕ ТАМБОВ И ЦВЗ

        //foreach($item_new->getJsonField('photo') as $file){
        //$item_new->createThumbnail($file);
        //$item_new->createMarkedImage($file);
        //}
    }




/////////////////СОБИРАЕМ ПРЕДЛОЖЕНИЯ
    $sql1 = $pdo->prepare("TRUNCATE TABLE c_industry_offers");
    $sql1->execute();


    $agent_types_arr = array('1'=>'agent','2'=>'agent_sale', '3'=>'agent_safe', '4'=>'agent_subrent');
    $agent_visit_types_arr = array('1'=>'agent_visited','2'=>'agent_visited_sale', '3'=>'agent_visited_safe', '4'=>'agent_visited_subrent');

    $num = 1;
    $sql = $pdo->prepare("SELECT * FROM c_industry WHERE deleted!='1'");
    $sql->execute();

    while($item = $sql->fetch(PDO::FETCH_LAZY)){

        $obj = new Building($item->id);

        $blocks_in_object = $obj->subItemsId();


        //смотрим типы сделки лота
        $deals = $item->deal_type_help;

        $deals = trim($deals,',');
        $deals_obj_arr = explode(',',$deals);

        $obj_id = $item->id;
        $company_id = $item->company_id;
        $contact_id = $item->contact_id;
        $agent_id = $item->agent_id;
        $agent_visit = $item->agent_visited;
        $tax_form = $item->tax_form;

        $last_update = $item->last_update;
        $deleted = $item->deleted;


        foreach($blocks_in_object as $block){

            $block_obj = new Subitem($block);

            $block_id = $block_obj->postId();
            $offer_deal = $block_obj->getField('deal_type'); //для каждого конкретного блока

            $deposit = $item->deposit; //залог
            $pledge = $item->pledge; //залог величина

            $prepay =  $item->prepay; //старховой депозит
            $prepay_value =  $item->prepay_value; //старховой депозит величина

            $ad_free = $item->import_free;

            $agent_field = $agent_types_arr[$offer_deal];
            //$agent_id = $item->$agent_field;

            //echo $agent_field;
            //echo '<br>';

            $agent_visited_field = $agent_visit_types_arr[$offer_deal];
            //$agent_visit = $item->$agent_visited_field;


            $site_noprice = $item->onsite_noprice;
            $site_show = $item->onsite;
            $site_show_top = $item->onsite_top;

            $desc = $item->description;
            //$desc = 'fddfd';
            $desc_auto = $item->description_auto;
            //$desc_hand = 'dfdfdfdf111';

            //$offer_status = $item->status_id;

            $commission_client = $item->owner_pays_howmuch_4client;
            $pay_through_holidays = $item->owner_pays_howmuch_rentholidays;


            $offer = new Post(0);
            $offer->getTable('c_industry_offers');


            /*
            if(in_array($offer_deal,$deals_obj_arr)){
                    $status = 1;
            }else{
                    $status = 2;
            }
            */


            if($offer_deal == '1' ){       //Аренда
                $insert_value = $item->_calc_rent_payinc;
                $commission_owner = $item->owner_pays_howmuch;

                $ad_free = $item->import_rent_free;

                $ad_cian = $item->import_rent_cian;
                $ad_cian_premium = $item->import_rent_cian_premium;
                $ad_cian_top3 = $item->import_rent_cian_top3;
                $ad_cian_hl = $item->import_rent_cian_hl;

                $ad_yandex = $item->import_rent_yandex;


                //$offer_status = $item->status_rent;
            }elseif($offer_deal == '2'){   //Продажа
                $insert_value = $item->_calc_sale_payinc;
                $commission_owner = $item->owner_pays_howmuch_sale;

                $ad_free = $item->import_sale_free;

                $ad_cian = $item->import_sale_cian;
                $ad_cian_premium = $item->import_sale_cian_premium;
                $ad_cian_top3 = $item->import_sale_cian_top3;
                $ad_cian_hl = $item->import_sale_cian_hl;

                $ad_yandex = $item->import_rent_yandex;


                //$offer_status = $item->status_sale;



            }elseif($offer_deal == '3'){   //Ответ хранение
                $insert_value = $item->_calc_safe_payinc ;
                $commission_owner = $item->owner_pays_howmuch_safe;

                $ad_free = $item->import_rent_free;

                $ad_cian = $item->import_rent_cian;
                $ad_cian_premium = $item->import_rent_cian_premium;
                $ad_cian_top3 = $item->import_rent_cian_top3;
                $ad_cian_hl = $item->import_rent_cian_hl;

                $ad_yandex = $item->import_rent_yandex;


                //$offer_status = $item->status_safe;

            }else{ //Субаренда
                $insert_value = $item->_calc_subrent_payinc;
                $commission_owner = $item->owner_pays_howmuch;

                $ad_free = $item->import_rent_free;

                $ad_cian = $item->import_rent_cian;
                $ad_cian_premium = $item->import_rent_cian_premium;
                $ad_cian_top3 = $item->import_rent_cian_top3;
                $ad_cian_hl = $item->import_rent_cian_hl;

                $ad_yandex = $item->import_rent_yandex;

                //$offer_status = $item->status_subrent;

            }
            //echo "У объекта $item->id поле включенных расходов";
            //var_dump( $insert_value);


            $insert_value = explode(',',trim($insert_value,','));

            for($i = 0; $i < count($insert_value); $i++){
                if(in_array($insert_value[$i],['nds','ndswithout','
                    ','triplenet'])){
                    unset($insert_value[$i]);
                }else{
                    if($insert_value[$i] == 'water'){
                        $insert_value[$i] = 3;
                    }elseif($insert_value[$i] == 'heat'){
                        $insert_value[$i] = 2;
                    }elseif($insert_value[$i] == 'e'){
                        $insert_value[$i] = 4;
                    }elseif($insert_value[$i] == 'opex'){
                        $insert_value[$i] = 1;
                    }else{

                    }
                }
            }
            sort($insert_value);

            $inc_services = json_encode($insert_value);

            //$inc_services = json_encode([]);

            $chl = $pdo->prepare("SELECT COUNT(*) as pr FROM c_industry_offers WHERE object_id='$obj_id' AND deal_type='$offer_deal'");
            $chl->execute();
            $inf = $chl->fetch(PDO::FETCH_LAZY);

            if($inf['pr'] == 0){
                $offer_id = $offer->createLine(
                    ['object_id', 'company_id', 'contact_id', 'inc_services', 'deal_type', 'tax_form', 'agent_id',  'agent_visited', 'last_update',    'description_auto', 'description', 'pay_through_holidays', 'commission_owner', 'commission_client', 'site_price_hide', 'ad_realtor', 'ad_realtor_top', 'deposit', 'pledge','ad_free', 'ad_cian', 'ad_cian_top3', 'ad_cian_hl', 'ad_cian_premium', 'ad_yandex', 'deleted'],
                    [ $obj_id,    $company_id,   $contact_id,  $inc_services, $offer_deal,  $tax_form,  $agent_id,   $agent_visit,   $last_update,      $desc_auto,         $desc,      $pay_through_holidays,  $commission_owner,  $commission_client,   $site_noprice,    $site_show,   $site_show_top,   $deposit,  $pledge,   $ad_free,  $ad_cian,  $ad_cian_top3,  $ad_cian_hl,  $ad_cian_premium,  $ad_yandex, $deleted]
                );
            }

            //$offer_id = $pdo->lastInsertId();


            $upd_sql = $pdo->prepare("UPDATE c_industry_blocks SET offer_id='$offer_id' WHERE id='$block_id'  ");
            $upd_sql->execute();



            /*
            if($status == 2){
                $upd_sql = $pdo->prepare("UPDATE c_industry_blocks SET status='2' WHERE id='$block_id' ");
                $upd_sql->execute();
            }
            */


            $num++;

        }
    }


    //Проставляем предложениям номера контактов
    $sql = $pdo->prepare("SELECT * FROM c_industry_offers ");
    $sql->execute();

    //для каждого запроса из таблицы запросов
    while ($offer = $sql->fetch(PDO::FETCH_LAZY)) {

//!!!!!!!!$company = new Company($offer->company_id);  /////////ТУТ ПУСТОЕ ЗНАЧЕНИЕ
        $offer_obj = new Offer($offer->id);
        $company = new Company($offer->company_id);
        //echo $company->getField('contact_id').'<br>';
        $offer_obj->updateField('contact_id',$company->getField('contact_id'));
    }



//include($_SERVER['DOCUMENT_ROOT'].'/table/export.php');

    echo time() - $starttime;
    echo 'trololololllolo';




    $exec_time = (time() - $start_time)/60;
    $message = 'Выгрузка окончена. Времени затрачено: '.$exec_time.' мин';
    $telegram = new Telegram('736512998:AAGIlIPVdPdrffvQRmh1Kwoj2_isbvYUKc4');
    $telegram->send($message,$logedUser->getField('telegram_id'));


}




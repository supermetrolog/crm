<?

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



include_once($_SERVER['DOCUMENT_ROOT'].'/system/classes/autoload.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

//$sale = $pdo->prepare("TRUNCATE TABLE items");
//$sale->execute();

function readExelFile($filepath){
    require_once 'PHPExcel.php'; //подключаем наш фреймворк
    $ar=array(); // инициализируем массив
    $inputFileType = PHPExcel_IOFactory::identify($filepath);  // узнаем тип файла, excel может хранить файлы в разных форматах, xls, xlsx и другие
    $objReader = PHPExcel_IOFactory::createReader($inputFileType); // создаем объект для чтения файла
    $objPHPExcel = $objReader->load($filepath); // загружаем данные файла в объект
    $ar = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
    return $ar; //возвращаем массив
}

$ar=readExelFile('industry_rules_9.xls');

echo count($ar);
echo '<br>';
echo '<br><br>';




$rules_location =[];

$regions_arr = [];
$towns_arr = [];
$towns_types_arr = [];
$districts_arr = [];
$districts_former_arr = [];
$highways_arr = [];
$highways_moscow_arr = [];
$metros_arr = [];



$locations_table='l_locations';

$regions_table='l_regions';
$towns_table='l_towns';
$towns_types_table='l_towns_types';
$districts_table='l_districts';
$districts_former_table='l_districts_former';
$highways_table='l_highways';
$highways_moscow_table='l_highways_moscow';
$metros_arr_table='l_metros';

//ОЧИЩАЕМ ВСЕ ТАБЛИЦЫ
$sql = $pdo->prepare("TRUNCATE TABLE $locations_table");
$sql->execute();

$sql = $pdo->prepare("TRUNCATE TABLE $regions_table");
$sql->execute();

$sql = $pdo->prepare("TRUNCATE TABLE $towns_table");
$sql->execute();

$sql = $pdo->prepare("TRUNCATE TABLE $towns_types_table");
$sql->execute();

$sql = $pdo->prepare("TRUNCATE TABLE $districts_table");
$sql->execute();

$sql = $pdo->prepare("TRUNCATE TABLE $districts_former_table");
$sql->execute();

$sql = $pdo->prepare("TRUNCATE TABLE $highways_table");
$sql->execute();

$sql = $pdo->prepare("TRUNCATE TABLE $highways_moscow_table");
$sql->execute();

$sql = $pdo->prepare("TRUNCATE TABLE $metros_arr_table");
$sql->execute();

//РЕГИОНЫ

$artificial_regions = ['Москва и МО','Москва внутри МКАД','МО+Новая москва'];
foreach($artificial_regions as $region) {
    $item = new Post(0);
    $item->getTable($regions_table);
    $item->createLine(['title'],[$region]);
}
$i = 0;
foreach($ar as $ar_row) {
    if ($i > 0 && $i < 100000 && $ar_row[0] != NULL) {
        //РЕГИОНЫ
        $arr_el = mb_strtolower(trim($ar_row[1]));
        if(!in_array($arr_el,$regions_arr) && $arr_el != NULL){
            array_push($regions_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($regions_table);
            $item->createLine(['title'],[$arr_el]);
        }
    }
    $i++;
}

//РАЙОНЫ
$i = 0;
foreach($ar as $ar_row) {
    if ($i > 0 && $i < 100000 && $ar_row[0] != NULL) {
        //РАЙОНЫ
        $arr_el = mb_strtolower(trim($ar_row[23]));
        if(!in_array($arr_el,$districts_arr) && $arr_el != NULL){
            array_push($districts_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($districts_table);
            $item->createLine(['title'],[$arr_el]);
        }
    }
    $i++;
}

//РАЙОНЫ БЫВШИЕ (СТАРЫЕ НАЗВАНИЯ)
$i = 0;
foreach($ar as $ar_row) {
    if ($i > 0 && $i < 100000 && $ar_row[0] != NULL) {
        //РАЙОНЫ БЫВШИЕ (СТАРЫЕ НАЗВАНИЯ)
        $arr_el = mb_strtolower(trim($ar_row[24]));
        if(!in_array($arr_el,$districts_former_arr) && $arr_el != NULL){
            array_push($districts_former_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($districts_former_table);
            $item->createLine(['title'],[$arr_el]);
        }
    }
    $i++;
}

//ТИПЫ НАСЕЛЕННЫХ ПУНКТОВ
$i = 0;
foreach($ar as $ar_row) {
    if ($i > 0 && $i < 100000 && $ar_row[0] != NULL) {
        //ТИПЫ НАСЕЛЕННЫХ ПУНКТОВ
        $arr_el = trim($ar_row[7]);
        $arr_el = mb_strtolower(trim($ar_row[7]));
        if(!in_array($arr_el,$towns_types_arr) && $arr_el != NULL){
            array_push($towns_types_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_types_table);
            $item->createLine(['title'],[$arr_el]);
        }
        $arr_el = mb_strtolower(trim($ar_row[9]));
        if(!in_array($arr_el,$towns_types_arr) && $arr_el != NULL){
            array_push($towns_types_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_types_table);
            $item->createLine(['title'],[$arr_el]);
        }
        $arr_el = mb_strtolower(trim($ar_row[11]));
        if(!in_array($arr_el,$towns_types_arr) && $arr_el != NULL){
            array_push($towns_types_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_types_table);
            $item->createLine(['title'],[$arr_el]);
        }
        $arr_el = mb_strtolower(trim($ar_row[13]));
        if(!in_array($arr_el,$towns_types_arr) && $arr_el != NULL){
            array_push($towns_types_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_types_table);
            $item->createLine(['title'],[$arr_el]);
        }
        $arr_el = mb_strtolower(trim($ar_row[15]));
        if(!in_array($arr_el,$towns_types_arr) && $arr_el != NULL){
            array_push($towns_types_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_types_table);
            $item->createLine(['title'],[$arr_el]);
        }
        $arr_el = mb_strtolower(trim($ar_row[17]));
        if(!in_array($arr_el,$towns_types_arr) && $arr_el != NULL){
            array_push($towns_types_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_types_table);
            $item->createLine(['title'],[$arr_el]);
        }
    }
    $i++;
}

//НАСЕЛЕННЫЕ ПУНКТЫ
$i = 0;
foreach($ar as $ar_row) {
    if ($i > 0 && $i < 100000 && $ar_row[0] != NULL) {
        //НАСЕЛЕННЫЕ ПУНКТЫ главн
        $arr_el = [mb_strtolower(trim($ar_row[6])),getPostIdByTitle('l_towns_types',mb_strtolower(trim($ar_row[7]))),getPostIdByTitle('l_districts',mb_strtolower(trim($ar_row[23])))];
        $arr_el_t = mb_strtolower(trim($ar_row[6]));
        if(!in_array($arr_el,$towns_arr) && $arr_el_t != NULL){
            array_push($towns_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_table);
            $item->createLine(['title', 'town_type', 'town_district'],$arr_el);
        }

        //НАСЕЛЕННЫЕ ПУНКТЫ основной
        $arr_el = [mb_strtolower(trim($ar_row[8])),getPostIdByTitle('l_towns_types',mb_strtolower(trim($ar_row[9]))),getPostIdByTitle('l_districts',mb_strtolower(trim($ar_row[23])))];
        $arr_el_t = mb_strtolower(trim($ar_row[8]));
        if(!in_array($arr_el,$towns_arr) && $arr_el_t != NULL){
            array_push($towns_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_table);
            $item->createLine(['title', 'town_type', 'town_district'],$arr_el);
        }

        $arr_el = [mb_strtolower(trim($ar_row[10])),getPostIdByTitle('l_towns_types',mb_strtolower(trim($ar_row[11]))),getPostIdByTitle('l_districts',mb_strtolower(trim($ar_row[23])))];
        $arr_el_t = mb_strtolower(trim($ar_row[10]));
        if(!in_array($arr_el,$towns_arr) && $arr_el_t != NULL){
            array_push($towns_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_table);
            $item->createLine(['title', 'town_type', 'town_district'],$arr_el);
        }

        $arr_el = [mb_strtolower(trim($ar_row[12])),getPostIdByTitle('l_towns_types',mb_strtolower(trim($ar_row[13]))),getPostIdByTitle('l_districts',mb_strtolower(trim($ar_row[23])))];
        $arr_el_t = mb_strtolower(trim($ar_row[12]));
        if(!in_array($arr_el,$towns_arr) && $arr_el_t != NULL){
            array_push($towns_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_table);
            $item->createLine(['title', 'town_type', 'town_district'],$arr_el);
        }

        $arr_el = [mb_strtolower(trim($ar_row[14])),getPostIdByTitle('l_towns_types',mb_strtolower(trim($ar_row[15]))),getPostIdByTitle('l_districts',mb_strtolower(trim($ar_row[23])))];
        $arr_el_t = mb_strtolower(trim($ar_row[14]));
        if(!in_array($arr_el,$towns_arr) && $arr_el_t != NULL){
            array_push($towns_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_table);
            $item->createLine(['title', 'town_type', 'town_district'],$arr_el);
        }

        $arr_el = [mb_strtolower(trim($ar_row[16])),getPostIdByTitle('l_towns_types',mb_strtolower(trim($ar_row[17]))),getPostIdByTitle('l_districts',mb_strtolower(trim($ar_row[23])))];
        $arr_el_t = mb_strtolower(trim($ar_row[16]));
        if(!in_array($arr_el,$towns_arr) && $arr_el_t != NULL){
            array_push($towns_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($towns_table);
            $item->createLine(['title', 'town_type', 'town_district'],$arr_el);
        }
    }
    $i++;
}



//ШОССЕ МО
$i = 0;
foreach($ar as $ar_row) {
    if ($i > 0 && $i < 100000 && $ar_row[0] != NULL) {
        //ШОССЕ МО
        $arr_el = mb_strtolower(trim($ar_row[25]));
        if(!in_array($arr_el,$highways_arr) && $arr_el != NULL){
            array_push($highways_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($highways_table);
            $item->createLine(['title'],[$arr_el]);
        }

        $arr_el = mb_strtolower(trim($ar_row[26]));
        if(!in_array($arr_el,$highways_arr) && $arr_el != NULL){
            array_push($highways_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($highways_table);
            $item->createLine(['title'],[$arr_el]);
        }
        $arr_el = mb_strtolower(trim($ar_row[27]));
        if(!in_array($arr_el,$highways_arr) && $arr_el != NULL){
            array_push($highways_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($highways_table);
            $item->createLine(['title'],[$arr_el]);
        }
        $arr_el = mb_strtolower(trim($ar_row[28]));
        if(!in_array($arr_el,$highways_arr) && $arr_el != NULL){
            array_push($highways_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($highways_table);
            $item->createLine(['title'],[$arr_el]);
        }
    }
    $i++;
}

//ШОССЕ МОСКВА
$i = 0;
foreach($ar as $ar_row) {
    if ($i > 0 && $i < 100000 && $ar_row[0] != NULL) {
        //ШОССЕ МОСКВА
        $arr_el = mb_strtolower(trim($ar_row[29]));
        if(!in_array($arr_el,$highways_moscow_arr) && $arr_el != NULL){
            array_push($highways_moscow_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($highways_moscow_table);
            $item->createLine(['title'],[$arr_el]);
        }

        $arr_el = mb_strtolower(trim($ar_row[30]));
        if(!in_array($arr_el,$highways_moscow_arr) && $arr_el != NULL){
            array_push($highways_moscow_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($highways_moscow_table);
            $item->createLine(['title'],[$arr_el]);
        }
        $arr_el = mb_strtolower(trim($ar_row[31]));
        if(!in_array($arr_el,$highways_moscow_arr) && $arr_el != NULL){
            array_push($highways_moscow_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($highways_moscow_table);
            $item->createLine(['title'],[$arr_el]);
        }
    }
    $i++;
}

//МЕТРО
$i = 0;
foreach($ar as $ar_row) {
    if ($i > 0 && $i < 100000 && $ar_row[0] != NULL) {
        //МЕТРО
        $arr_el = mb_strtolower(trim($ar_row[32]));
        if(!in_array($arr_el,$metros_arr) && $arr_el != NULL){
            array_push($metros_arr,$arr_el);
            $item = new Post(0);
            $item->getTable($metros_arr_table);
            $item->createLine(['title'],[$arr_el]);
        }
    }
    $i++;
}



$i = 0;
foreach($ar as $ar_row){
    if($i > 0 && $i < 100000 && $ar_row[0] != NULL ){

        //Проставляем объектам ID

        $object_id = array_shift($ar_row);

        if(!in_array($ar_row,$rules_location)){
            array_push($rules_location,$ar_row);

            $item = new Post(0);
            $item->getTable($locations_table);
            $item->createLine([            'region',                'outside_mkad',  'show_inside_mkad', 'show_in_mo', 'cian_msk_and_closest',                              'town',                                                 'town_type',                                              'town_main',                                                                                                                      'towns_relevant',                                                                                                                                     'direction',                                                 'direction_relevant',                                                   'district_moscow',                                          'district_moscow_relevant',                                               'district_type',                                        'district',                                                     'district_former',                                              'highway',                                                                                 'highways_relevant',                                                                                                                                     'highway_moscow',                                                           'highways_moscow_relevant',                                                                    'metro'],
                [  getPostIdByTitle('l_regions',$ar_row[0]),      $ar_row[1],        $ar_row[2],      $ar_row[3],     $ar_row[4],               getTown($ar_row, 5, 6, $pdo),     getPostIdByTitle('l_towns_types',trim($ar_row[6])),      getTown($ar_row, 7, 8, $pdo),      json_encode([  getTown($ar_row, 9, 10, $pdo),  getTown($ar_row, 11, 12, $pdo),  getTown($ar_row, 13, 14, $pdo), getTown($ar_row, 15, 16, $pdo)]),       getPostIdByTitle('l_directions',trim($ar_row[17])),       getPostIdByTitle('l_directions', trim($ar_row[18])),        getPostIdByTitle('l_districts_moscow',trim($ar_row[19])),     getPostIdByTitle('l_districts_moscow',trim($ar_row[20])),       getPostIdByTitle('l_districts_types',trim($ar_row[21])),      getPostIdByTitle('l_districts',$ar_row[22]),        getPostIdByTitle('l_districts_former',$ar_row[23]),        getPostIdByTitle('l_highways',$ar_row[24]),     json_encode([getPostIdByTitle('l_highways',$ar_row[25]),getPostIdByTitle('l_highways',$ar_row[26]),getPostIdByTitle('l_highways',$ar_row[27])]),        getPostIdByTitle('l_highways_moscow',$ar_row[28]),       json_encode([ getPostIdByTitle('l_highways_moscow',$ar_row[29]), getPostIdByTitle('l_highways_moscow',$ar_row[30])]),       getPostIdByTitle('l_metros',$ar_row[31])]);

            $location_id = $item->id;
        }

        if($object_id != 'x'){
            $object = new Building($object_id);
            $object->updateField('location_id',$location_id);
        }

    }
    $i++;

}


function getTown($ar_row, $town_col, $town_type_col, $pdo){
    $town_title = trim($ar_row[$town_col]);
    $town_type_id  = getPostIdByTitle('l_towns_types',trim($ar_row[$town_type_col]));
    return getTownIdByTitleAndType($town_title,$town_type_id, $pdo);
}


//var_dump($metros_arr);
//var_dump($towns_arr);
//var_dump($towns_types_arr);
//var_dump($districts_arr);
//var_dump($districts_former_arr);
//var_dump($highways_arr);
//var_dump($highways_moscow_arr);
//echo "Выгрузка прошла успешно: Создано  $count строк, Обновлено $upd_count строк($fld_count полей)";
echo "Выгрузка прошла успешно: Создано  $count строк, Обновлено  полей)";

echo $i;


?>
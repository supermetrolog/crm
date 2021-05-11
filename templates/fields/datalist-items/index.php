<?php
//echo 111;

include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');

//include_once($_SERVER['DOCUMENT_ROOT'].'/errors.php');

$search = mb_strtolower($_POST['search']);
$table = $_POST['table'];


//echo $search;
//echo $table;
//echo $_POST['company_id'];

if($_POST['company_id'] || $_POST['client_company_id'] || $_POST['owner_company_id']){
    ($_POST['company_id'])? $company_id = $_POST['company_id'] : '';
    ($_POST['client_company_id'])? $company_id = $_POST['client_company_id'] : '';
    ($_POST['owner_company_id'])? $company_id = $_POST['owner_company_id'] : '';
    //$sql_text = "SELECT * FROM $table WHERE company_id=".(int)$company_id."  OR id LIKE '%$search%'  AND deleted!=1 LIMIT 10";
    $sql_text = "SELECT * FROM $table WHERE company_id=".(int)$company_id."  AND deleted!=1 LIMIT 10";
    //echo $sql_text;
}elseif(in_array($table,['l_locations'])){
    $sql_text = "SELECT l.id as id, t.title as title, t.town_type as town_type, t.town_district as town_district FROM $table l RIGHT JOIN l_towns t ON l.town=t.id  WHERE (t.title LIKE '%$search%' OR  l.id='$search'  ) AND t.title!='москва' AND t.deleted!=1 GROUP BY t.title,t.town_type,t.town_district  LIMIT 10";
}elseif(in_array($table,['l_regions','l_districts','l_districts_former','l_districts_moscow','l_towns','l_towns_central','l_highways','l_directions','l_highways_moscow','l_metros'])){
    $sql_text = "SELECT * FROM $table WHERE title LIKE '%$search%'  AND deleted!=1  LIMIT 10";
    //echo $sql_text;
}else{
    $sql_text = "SELECT * FROM $table WHERE title LIKE '%$search%' OR title_eng LIKE '%$search%' OR title_old LIKE '%$search%' OR id LIKE '%$search%'  AND deleted!=1  LIMIT 10";
    //echo $sql_text;
}



//include_once($_SERVER['DOCUMENT_ROOT'].'/display_errors.php');

$sql = $pdo->prepare($sql_text);
$sql->execute();

$arr = [];




while($item = $sql->fetch(PDO::FETCH_LAZY)){
    $unit_arr = [];
    $unit_arr[0] = $item->id;
    if($_POST['company_id']){
        if($item->first_name){
            $name = mb_strtolower($item->last_name).' '.mb_strtolower($item->first_name).' '.mb_strtolower($item->father_name);
        }else{
            $name = mb_strtolower($item->title);
        }

    }else{
        $name = $item->title_old;
        if($item->title){
            $name = mb_strtolower($item->title);
        }

    }
    $tables_dope_info = [
       'l_towns',
       'l_towns_central',
       'l_districts',
       'l_districts_former',
       'l_locations',

    ];



    $unit_arr[1] = str_replace('"','',$name);

    if(in_array($table,$tables_dope_info)){
        $town_type = new Post($item->town_type);
        $town_type->getTable('l_towns_types');
        $town_type = $town_type->title();

        $town_district = new Post($item->town_district);
        $town_district->getTable('l_districts');

        $unit_arr[2] = $town_type;
        $unit_arr[3] = $town_district->title();

        if($table == 'l_locations'){
            if($type_id = $town_district->getField('district_type')){
                $town_district_type = new Post($type_id);
                $town_district_type->getTable('l_districts_types');
                $unit_arr[4] = $town_district_type->title();
            }
        }
    }





    $arr[] = $unit_arr;

    /*?>
    <div onclick="$(this).closest('.datalist-field').find('.field-list-variants').hide()" class="datalist-item"  data-id="<?=$item->id?>" data-title="<?=str_replace('"','',$item->title)?>"><?=$item->title?></div>
<?*/}?>

<?=json_encode($arr, JSON_UNESCAPED_UNICODE)?>

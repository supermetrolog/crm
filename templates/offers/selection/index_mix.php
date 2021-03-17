<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); ini_set('error_reporting', E_ALL);

?>
<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?php

$objects = new Item(0);

?>


<? require(PROJECT_ROOT.'/templates/filters/selection/objects/index_mix.php');?>
<?


$pageItems = 50;
if($filters_arr->page_num){
    $page_num = $filters_arr->page_num;
}else{
    $page_num = 1;
}

$curr_num = $pageItems*($page_num-1);



$sql_search_text = "FROM  c_industry_offers_mix o $join_line WHERE o.type_id IN(2,3) AND o.deleted!=1   $filter_line $sort_part";

$full_request = "SELECT o.id as oid $sql_search_text  LIMIT $curr_num, $pageItems ";

if($logedUser->member_id() == 141){
    echo $full_request;
}



$unique_offers = [];

$sql_objects = $pdo->prepare($full_request);
$sql_objects->execute();

while($offer = $sql_objects->fetch()){
    $unique_offers[] = $offer['oid'];
    //$unique_offers[] = (object)$offer;

}



$sql_objects_count = $pdo->prepare("SELECT COUNT(DISTINCT o.object_id) as a, COUNT(o.id) as b $sql_search_text  ");
$sql_objects_count->execute();
$count_res = $sql_objects_count->fetch();

$objectsAmount = $count_res['a'];
$offersAmount = $count_res['b'];

$pagesAmount = $offersAmount/$pageItems;



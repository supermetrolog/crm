<?php

//ini_set('display_errors', 1); ini_set('display_startup_errors', 1); ini_set('error_reporting', E_ALL);

?>
<? include_once($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>
<?php

$objects = new Item(0);

?>


<? require(PROJECT_ROOT.'/templates/filters/selection/objects/index.php');?>
<?


$pageItems = 50;
if($filters_arr->page_num){
    $page_num = $filters_arr->page_num;
}else{
    $page_num = 1;
}

$curr_num = $pageItems*($page_num-1);




/*
 $sql_search_text = "FROM  c_industry i
                                       LEFT JOIN  c_industry_offers o  ON o.object_id=i.id
                                       LEFT JOIN c_industry_blocks b ON b.offer_id=o.id
                                       LEFT JOIN l_locations l ON l.id=i.location_id
                                       LEFT JOIN core_users u ON u.id=o.agent_id

                                       $join_line WHERE  i.deleted!=1  AND o.deleted!=1 AND b.deleted!=1;  $search_fil $filter_line  $sort_part ";
 */

$sql_search_text = "FROM  c_industry i  
                                          
                                       LEFT JOIN  c_industry_offers o  ON i.id=o.object_id      
                                       LEFT JOIN c_industry_blocks b ON b.offer_id=o.id      
                                       LEFT JOIN l_locations l ON l.id=i.location_id    
                                       LEFT JOIN core_users u ON u.id=o.agent_id                                                                                                    
                                                  
                                       $join_line WHERE  i.deleted!=1   $search_fil $filter_line  $sort_part ";


$sql_search_text_1 = "FROM  c_industry_complex cx             
                                       LEFT JOIN c_industry i ON i.complex_id=cx.id             
                                       LEFT JOIN c_industry_offers o ON o.object_id=i.id          
                                       LEFT JOIN c_industry_blocks b ON b.offer_id=o.id      
                                       LEFT JOIN l_locations l ON l.id=cx.location_id     
                                       LEFT JOIN core_users u ON u.id=o.agent_id                                                                                                          
                                                  
                                       $join_line WHERE  i.deleted!=1   $search_fil $filter_line  $sort_part ";

$sql_search_text_3 = "FROM  c_industry i     
                                       LEFT JOIN  c_industry_offers o  ON i.id=o.object_id      
                                       LEFT JOIN c_industry_blocks b ON b.offer_id=o.id      
                                       LEFT JOIN l_locations l ON l.id=i.location_id    
                                       LEFT JOIN core_users u ON u.id=o.agent_id                                                                                                    
                                                  
                                       $join_line WHERE  i.deleted!=1   $search_fil $filter_line  $sort_part ";
if($_COOKIE['member_id'] == 141){
    $full_request = "SELECT DISTINCT o.id $sql_search_text_1 LIMIT $curr_num, $pageItems  ";
    //$full_request = "SELECT DISTINCT  b.id $sql_search_text LIMIT $curr_num, $pageItems ";
}else{
    $full_request = "SELECT DISTINCT  o.id $sql_search_text_1 LIMIT $curr_num, $pageItems ";
}
//include_once $_SERVER['DOCUMENT_ROOT'].'/errors.php';

if($logedUser->member_id() == 141){
    echo $full_request;
    echo '<br>333<br>'.$search_fil;

}



$unique_offers = [];
$unique_objects = [];


$sql_objects = $pdo->prepare($full_request);
$sql_objects->execute();

//var_dump($sql_objects);


$sql_objects_count = $pdo->prepare("SELECT COUNT(DISTINCT i.id) as a, COUNT(DISTINCT o.id) as b $sql_search_text_1  ");
$sql_objects_count->execute();
$count_res = $sql_objects_count->fetch();
//var_dump($count_res);
$i =0;
while($offer = $sql_objects->fetch(PDO::FETCH_LAZY)){
    $unique_offers[] = $offer->id;
    $i++;

}
//var_dump($i);
//echo 'dfgdfgdfgdfgdfgdfgfdgfdgfdg';
$objectsAmount = $count_res['a'];
$offersAmount = $count_res['b'];
$pagesAmount = $offersAmount/$pageItems;

$factory = new Factory();

?>


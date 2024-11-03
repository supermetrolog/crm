<?php
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('error_reporting', E_ALL);
*/

?>

<? require($_SERVER['DOCUMENT_ROOT'].'/global_pass.php');?>

<? require(PROJECT_ROOT.'/templates/filters/selection/objects/index.php');?>

<?




$unique_objects = [];       
$unique_companies = [];
$sql_text_obj = "SELECT DISTINCT  i.id, i.company_id FROM  c_industry_complex cx          
                                            LEFT JOIN  c_industry i ON i.complex_id=cx.id 
                                            LEFT JOIN  c_industry_offers o  ON o.object_id=i.id  
                                            LEFT JOIN c_industry_blocks b ON b.offer_id=o.id
                                            LEFT JOIN l_locations l ON l.id=i.location_id
                                            LEFT JOIN core_users u ON u.id=o.agent_id  
                                                   
                                            $join_line  WHERE i.deleted!='1' AND o.deleted!='1' AND b.deleted!='1'  $search_fil $filter_line ";
$sql_objects = $pdo->prepare($sql_text_obj);

//echo $sql_text_obj;

//file_put_contents('test.txt',$sql_text_obj);



$sql_objects->execute();
while($obj = $sql_objects->fetch(PDO::FETCH_LAZY)){
    /*
    if(!in_array($obj->object_id,$unique_objects)){
        $unique_objects[] = $obj->object_id;
    }
    */
    $unique_objects[] = $obj->id;
    $unique_companies[] = $obj->company_id;
}
$objectsAmount = count($unique_objects);



$factory = new Factory();



?>
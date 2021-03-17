		    		    <?

$sql=$pdo->prepare("SELECT * FROM c_industry");
$sql->execute();
/*
while($item = $sql->fetch()){


    $id = $item['id'];
    $time=strtotime($item['dt_insert']);
    $last_update = strtotime($item['dt_update_full']);
    $sql_update=$pdo->prepare("UPDATE c_industry SET publ_time='$time', last_update='$last_update' WHERE id='$id'");
    var_dump($sql_update);
    if($sql_update->execute()){
        echo 'Обновлено------';
    }


}

while($item = $sql->fetch()){
	
	
	//$test = trim($item['purposes'], ',');
	echo  $test ;
	echo '<br>';
	var_dump(',3,');
	
	//var_dump(explode(',',trim($item['purposes'],",")));
	echo '<br>';
	echo '<br>';
	echo json_decode(trim($item['purposes']));
   $new_purp = json_encode(explode(',',trim(trim($item['deal_type'],","))));
   //echo trim($item['purposes'],",")."=?=".trim('22,23',",");
   //$new_purp = json_encode(explode(',',trim(',22,23,',",")));
   //$new_purp = json_encode(22,23);
    //$new_purp = json_decode($item['purposes']);
   echo $new_purp;   
   $id = $item['id'];   
   $sql_update=$pdo->prepare("UPDATE c_industry SET deal_type2=:val WHERE id=$id");
   $sql_update->bindParam(':val',$new_purp);
   var_dump($sql_update);
   if($sql_update->execute()){
      echo '------';
   }
   
}

*/
	    										
<?
$sql = $pdo->prepare("SELECT * FROM c_industry ");
$sql->execute();
while($item = $sql->fetch(PDO::FETCH_LAZY)){
  $old_val = trim($item->object_type2,',');
  $old_val = str_replace(',,',',',$old_val);
  $arr_str = json_encode(explode(',',$old_val));
 $sql_upd = $pdo->prepare("UPDATE c_industry SET purposes='".$arr_str."' WHERE id='".$item->id."' ");
if($sql_upd->execute()){
 echo 'заменили <br>';
}


}
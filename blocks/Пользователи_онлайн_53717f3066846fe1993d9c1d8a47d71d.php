<?
$source = $pdo->prepare("SELECT * FROM visitors $active");		
$source->execute();
while($src = $source->fetch()){
 $date = date("d.m.y в G:i",$src['publ_time']); 
 ?>
 <div>	    
 <? if($src['user_id'] > 0 ){?>
  <a href='<?=PROJECT_URL?>//user/?member_id=<?=$src['><b><?=$src['title']?></b></a>
 <?}else{ ?>
  <?=$src['title']?>
 <? } ?>		  
 <?=$src['ip_address']?>
 <?=$date?>
 </div>
<? } ?>	    		
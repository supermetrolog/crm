										<div class="container_slim">
		   <?
		     $collection_sql = $pdo->prepare("SELECT * FROM $table_collections $active ORDER BY order_row DESC"); 
		     $collection_sql->execute();
		     while($collection = $collection_sql->fetch()){
		     $photo = unserialize($collection["photo"]); 		
		   ?>
			<div class="collection_sec" style="background: url(<?=PROJECT_URL.'/'.$photo[0]?>); ">
				
				<div class="title">
					<a  href="<?=PROJECT_URL?>//catalog/<?=$collection["furl"]?>/"><?=$collection["title"]?></a>
				</div>
			</div>
		  <?}?>
			
		</div><div style='margin-bottom: 50px;'></div>																				
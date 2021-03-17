		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    		    				<div class="items">
		    <?php
 
			    $item_sql = $pdo->prepare("SELECT * FROM $table_items $active  ORDER BY id DESC LIMIT 12");
				$item_sql->execute();
				$i = 0;
				while($item = $item_sql->fetch()){
				 $photo = unserialize($item["photo"]);?> 
		     <div class="item">
	          <div class="item_in">				
				<a href="<?=PROJECT_URL?>//card/?id=<?=$item["id"]?>">
				 <div class="photo">
				   <img src="<?=$photo[0]?>"/>
				 </div>
				</a>
	          </div>
	        </div>    
		              <? }?>
		</div>																																																																		
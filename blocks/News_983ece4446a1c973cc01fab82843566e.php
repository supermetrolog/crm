		 <div class='custom_database'>
  <?
   $database_sql = $pdo->prepare("SELECT * FROM core_databases WHERE id='1'");		
   //$database_sql->bindParam(':id', 1);
   $database_sql->execute();
   $database_src = $database_sql->fetch();
   $database = new Post('core_databases', $database_src['id'], $pdo);

  ?>
   <h1><?=$database->title()?></h1> 
   <div class='posts_template_container'>	
   <?
   $source = $pdo->prepare("SELECT * FROM database_records WHERE activity='1' ORDER BY order_row DESC");		
   $source->execute();
   while($src = $source->fetch()){
    $record = new Record($src['id']);	   ?>
    <article class='database_post_unit database-column-<?=$database_src['database_template']?> bitkit_box'> 
     <div class='cmsRecord_image'> 
	  <a href='<?=PROJECT_URL?>/record/<?=$record->furl()?>/<?=$record->record_id()?>'>
       <img  src='<?=$record->thumb_cover()?>'/> 
	  </a> 
     </div>
	 <div> 
	   <div class='post_title'>   
	     <h2>
		   <a href='<?=PROJECT_URL?>/record/<?=$record->furl()?>/<?=$record->record_id()?>'> <?=$record->title()?></a>
		 </h2>
	     <span><?=$record->publ_time()?></span>
	   </div><br>
	   <div class='post_description'>
	     <?=mb_strimwidth(strip_tags($record->description()), 0, 250, "...") ?>
	   </div>
     </div>
    </article>
   <? } ?>
   </div>
</div>		
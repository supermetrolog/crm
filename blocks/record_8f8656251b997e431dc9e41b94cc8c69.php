<div class='cms_record_page'>
	<div class='record_container bitkit_box text_left'>	
 <? $record_id = explode("/",trim($_SERVER["PATH_INFO"], "/"))[2];
    $record = new Record($record_id);	   ?>
		<article> 
			<div class='record_info'>	
				<h1><?=$record->title()?></h1>
				<span><?=$record->publ_time()?></span>
			</div>
			<hr>
			<div> 
				<div class='post_text'>
					<?=$record->description()?>
				</div>
			</div>
		</article>
	</div>
</div>				  		
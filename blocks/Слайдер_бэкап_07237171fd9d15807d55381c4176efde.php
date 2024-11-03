												<div class="header" >
		 <div class="menu_start_top">
		  <ul> 
		   <li class="logo_sign black"><a href="PROJECT_URL.'/'"><img src='<?=PROJECT_URL.'/'.$logo?>'/><span></span></a></li>
		   <?
	    $menu_sql = $pdo->prepare("SELECT * FROM pages $active ORDER BY order_row DESC");
        $menu_sql->execute();    
		while($menu_item = $menu_sql->fetch()){
          $permissions_arr = unserialize($menu_item['permissions']);
          if($logedUser->can_see($permissions_arr) ) {		  
		   ($menu_item['link'] != ' ') ? $page_link = $menu_item['link'] : $page_link = '/?page='.$menu_item['id'] ;?>
		   <li ><a href="<?=PROJECT_URL.'/'.$page_link?>"><?=$menu_item['title']?></a></li>
		<?}
		}?>
                  <li><button class='liblenn_button'><i class="fa fa-search" aria-hidden="true"></i></button></li>
                  <li><button class='liblenn_button'><i class="fa fa-lock" aria-hidden="true"></i></button></li>
                  <li><button class='liblenn_button'><i class="fa fa-shopping-bag" aria-hidden="true"></i></button></li>
		  </ul>
		 </div>
		</div>
		<div  class="flexslider banners" >
			<ul class="slides">
			 <?php
			    $banner_sql = $pdo->prepare("SELECT * FROM $table_ban $active"); 
		        $banner_sql->execute();
				while($banner = $banner_sql->fetch()){
				 $photo = unserialize($banner["photo"]);?> 
				<li>
                                 <div class='desktop_banners' >
				  <a href="<?=$banner["link"]?>">
				   <img src="<?=PROJECT_URL.'/'.$photo[0]?>"/>
				  </a>
                                 </div>
                                 <div class='mobile_banners'>
				  <a href="<?=$banner["link"]?>">
				   <img src="<?=PROJECT_URL.'/'.$banner['photo_small']?>"/>
				  </a> 
                                 </div>
				</li>
                                
				<? }?>
			</ul>
		</div>
																  		